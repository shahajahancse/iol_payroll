<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iclock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->database();
    }

    /**
     * Helper to log all incoming ADMS requests to application/logs/iclock_debug.log
     */
    private function log_debug($endpoint, $extra_info = '') {
        $log_file = APPPATH . 'logs/iclock_debug.log';
        $time = date('Y-m-d H:i:s');
        $ip = $this->input->ip_address();
        $method = $this->input->method(TRUE);
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $raw_input = file_get_contents('php://input');
        $get = json_encode($_GET);
        $post = json_encode($_POST);

        $log_entry = "==================================================\n";
        $log_entry .= "[{$time}] IP: {$ip} | Method: {$method} | Endpoint: {$endpoint}\n";
        $log_entry .= "URI: {$uri}\n";
        $log_entry .= "GET Params: {$get}\n";
        $log_entry .= "POST Params: {$post}\n";
        $log_entry .= "RAW INPUT BODY:\n" . (empty($raw_input) ? "(empty)\n" : "{$raw_input}\n");
        if (!empty($extra_info)) {
            $log_entry .= "PROCESSING LOGS:\n{$extra_info}\n";
        }
        $log_entry .= "==================================================\n\n";

        @file_put_contents($log_file, $log_entry, FILE_APPEND);
    }

    /**
     * ADMS Main Communication Endpoint
     * Handles device handshake (GET) and attendance logs push (POST)
     */
    public function cdata() {
        $sn = $this->input->get_post('SN');
        if (empty($sn)) {
            $sn = $this->input->get_post('sn');
        }

        $table = $this->input->get_post('table');
        $method = $this->input->method(TRUE);

        // Update device heartbeat and IP
        if (!empty($sn)) {
            $this->update_device_info($sn);
        }

        $raw_data = file_get_contents('php://input');
        if (empty($raw_data)) {
            $raw_data = isset($_POST['data']) ? $_POST['data'] : '';
        }

        // 1. GET Request: Device Handshake / Heartbeat Init
        if ($method === 'GET' && empty($raw_data)) {
            $this->log_debug('cdata (GET Handshake)', "SN: {$sn} | Table: {$table}");
            if (!empty($sn)) {
                $response = "GET OPTION FROM: {$sn}\n" .
                            "Stamp=9999\n" .
                            "OpStamp=9999\n" .
                            "ErrorDelay=60\n" .
                            "Delay=30\n" .
                            "TransTimes=00:00;14:00\n" .
                            "TransInterval=1\n" .
                            "TransFlag=1111111111\n" .
                            "Realtime=1\n" .
                            "Encrypt=0\n";
                echo $response;
            } else {
                echo "OK";
            }
            return;
        }

        // 2. Attendance Logs Transmission (POST or GET with raw payload)
        $processed_count = 0;
        $debug_details = [];

        if (!empty($raw_data)) {
            $lines = explode("\n", str_replace("\r", "", trim($raw_data)));
            $debug_details[] = "Total lines in raw payload: " . count($lines);

            foreach ($lines as $idx => $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // Handle tab or space separated lines
                $parts = preg_split('/\s+/', $line);
                $debug_details[] = "Line #{$idx}: '{$line}' -> Parts count: " . count($parts) . " [" . implode(' | ', $parts) . "]";

                $proxi_id = null;
                $date_time = null;

                if (count($parts) >= 2) {
                    // Check if line starts with header string (e.g. ATTLOG)
                    if (strtoupper($parts[0]) === 'ATTLOG' || strtoupper($parts[0]) === 'OPERLOG') {
                        array_shift($parts); // Remove header keyword
                    }

                    if (count($parts) >= 2) {
                        $proxi_id = trim($parts[0]);

                        // Format 1: Parts 1 and 2 form Date and Time (e.g., "2026-10-05" "09:50:00")
                        if (isset($parts[1]) && isset($parts[2]) && preg_match('/^\d{4}[-\/]\d{2}[-\/]\d{2}$/', $parts[1]) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $parts[2])) {
                            $date_time = str_replace('/', '-', $parts[1]) . ' ' . $parts[2];
                        } 
                        // Format 2: Part 1 contains both Date and Time (e.g., "2026-10-05 09:50:00")
                        else if (preg_match('/^\d{4}[-\/]\d{2}[-\/]\d{2} \d{2}:\d{2}:\d{2}$/', $parts[1])) {
                            $date_time = str_replace('/', '-', $parts[1]);
                        }
                    }
                }

                if (!empty($proxi_id) && $proxi_id !== 'No.' && !empty($date_time)) {
                    $inserted = $this->insert_attendance_punch($proxi_id, $date_time);
                    if ($inserted) {
                        $processed_count++;
                        $debug_details[] = " -> SUCCESS: Inserted User PIN {$proxi_id} @ {$date_time}";
                    } else {
                        $debug_details[] = " -> SKIPPED: Duplicate or DB error for User PIN {$proxi_id} @ {$date_time}";
                    }
                } else {
                    $debug_details[] = " -> SKIPPED: Could not extract valid proxi_id & date_time";
                }
            }
        } else {
            $debug_details[] = "No payload / raw data received.";
        }

        if (!empty($sn) && $processed_count > 0) {
            $this->db->query("UPDATE iclock_devices SET total_records = total_records + {$processed_count} WHERE sn = " . $this->db->escape($sn));
        }

        $extra_log = implode("\n", $debug_details) . "\nTotal processed: {$processed_count}";
        $this->log_debug('cdata (Payload)', $extra_log);

        echo "OK: " . $processed_count;
    }

    /**
     * Device polling for pending commands
     */
    public function getrequest() {
        $sn = $this->input->get_post('SN');
        if (!empty($sn)) {
            $this->update_device_info($sn);
        }
        $this->log_debug('getrequest', "SN: {$sn}");
        echo "OK";
    }

    /**
     * Command execution feedback from device
     */
    public function devicecmd() {
        $sn = $this->input->get_post('SN');
        if (!empty($sn)) {
            $this->update_device_info($sn);
        }
        $this->log_debug('devicecmd', "SN: {$sn}");
        echo "OK";
    }

    public function registry() {
        $this->log_debug('registry');
        echo "OK";
    }

    public function push() {
        $this->log_debug('push');
        echo "OK";
    }

    /**
     * Dynamically insert punch into monthly table att_YYYY_MM
     */
    private function insert_attendance_punch($proxi_id, $date_time) {
        $time_stamp = strtotime($date_time);
        if (!$time_stamp) return false;

        $att_table = "att_" . date("Y_m", $time_stamp);

        // Ensure table att_YYYY_MM exists
        if (!$this->db->table_exists($att_table)) {
            $this->db->query('CREATE TABLE IF NOT EXISTS `' . $att_table . '`(
                 `att_id` int(11) NOT NULL AUTO_INCREMENT,
                 `device_id` int(11) NOT NULL DEFAULT 1,
                 `proxi_id` varchar(30) NOT NULL,
                 `date_time` datetime NOT NULL,
                  PRIMARY KEY (`att_id`),
                  UNIQUE KEY `proxi_time` (`proxi_id`,`date_time`),
                  KEY `device_id` (`device_id`,`proxi_id`,`date_time`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
            );
        }

        // Check duplicate
        $query = $this->db->where('proxi_id', $proxi_id)
                          ->where('date_time', $date_time)
                          ->get($att_table);

        if ($query->num_rows() == 0) {
            $data = array(
                'device_id' => 1,
                'proxi_id'  => $proxi_id,
                'date_time' => $date_time
            );
            return $this->db->insert($att_table, $data);
        }

        return false;
    }

    /**
     * Update device last activity log
     */
    private function update_device_info($sn) {
        $ip = $this->input->ip_address();
        $now = date('Y-m-d H:i:s');

        $query = $this->db->where('sn', $sn)->get('iclock_devices');

        if ($query->num_rows() == 0) {
            $this->db->insert('iclock_devices', array(
                'sn'            => $sn,
                'device_name'   => 'SenseFace 4A',
                'ip_address'    => $ip,
                'last_activity' => $now,
                'total_records' => 0
            ));
        } else {
            $this->db->where('sn', $sn)->update('iclock_devices', array(
                'ip_address'    => $ip,
                'last_activity' => $now
            ));
        }
    }

    /**
     * View debug log or clear it
     */
    public function view_log() {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $log_file = APPPATH . 'logs/iclock_debug.log';

        if ($this->input->get('action') === 'clear') {
            @file_put_contents($log_file, '');
            redirect('iclock/device_list');
            return;
        }

        if (file_exists($log_file)) {
            $content = file_get_contents($log_file);
        } else {
            $content = "No log file found yet at " . $log_file;
        }

        header('Content-Type: text/plain; charset=utf-8');
        echo $content;
    }

    /**
     * Admin view page to monitor connected ZKTeco ADMS devices
     */
    public function device_list() {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        $this->data['username']  = !empty($this->data['user_data']->id_number) ? $this->data['user_data']->id_number : '';
        $this->data['devices']   = $this->db->order_by('last_activity', 'DESC')->get('iclock_devices')->result();
        $this->data['title']     = 'ADMS Devices';
        
        $log_file = APPPATH . 'logs/iclock_debug.log';
        if (file_exists($log_file)) {
            $this->data['log_content'] = file_get_contents($log_file);
        } else {
            $this->data['log_content'] = '';
        }

        $this->data['subview']   = 'attn_report/adms_device_list';
        $this->load->view('layout/template', $this->data);
    }
}


