<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iclock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->database();
    }

    /**
     * Dynamic log file path getter (respects CodeIgniter $config['log_path'])
     */
    private function get_log_file_path() {
        $config_path = $this->config->item('log_path');
        if (!empty($config_path)) {
            $dir = rtrim($config_path, '/\\') . '/';
        } else {
            $dir = APPPATH . 'logs/';
        }

        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        return $dir . 'iclock_debug.log';
    }

    /**
     * Helper to log all incoming ADMS requests
     */
    private function log_debug($endpoint, $extra_info = '') {
        $log_file = $this->get_log_file_path();
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
            if (!empty($sn)) {
                $response = "GET OPTION FROM: {$sn}\n" .
                            "Stamp=99999999\n" .
                            "OpStamp=99999999\n" .
                            "PhotoStamp=99999999\n" .
                            "ErrorDelay=30\n" .
                            "Delay=10\n" .
                            "TransTimes=00:00;23:59\n" .
                            "TransInterval=1\n" .
                            "TransFlag=1111111111\n" .
                            "Realtime=1\n" .
                            "Encrypt=0\n" .
                            "ServerVer=3.4.1\n" .
                            "PushProtVer=1.0\n";
                echo $response;
            } else {
                echo "OK";
            }
            return;
        }

        // 2. Attendance Logs Transmission (POST or GET with raw payload)
        $processed_count = 0;
        $has_punch_data = false;
        $debug_details = [];

        if (!empty($raw_data)) {
            $lines = explode("\n", str_replace("\r", "", trim($raw_data)));

            foreach ($lines as $idx => $line) {
                $line = trim($line);
                if (empty($line)) continue;

                $proxi_id = null;
                $date_time = null;

                // Mode 1: Key=Value pairs format (e.g. table=rtlog -> time=2026-10-05 09:57:59\tpin=3012...)
                if (strpos($line, '=') !== false) {
                    $items = (strpos($line, "\t") !== false) ? explode("\t", $line) : explode(' ', $line);
                    $kv = array();
                    foreach ($items as $item) {
                        $item = trim($item);
                        if (empty($item)) continue;
                        $pair = explode('=', $item, 2);
                        if (count($pair) == 2) {
                            $key = strtolower(trim($pair[0]));
                            $val = trim($pair[1]);
                            $kv[$key] = $val;
                        }
                    }

                    // Extract PIN
                    if (isset($kv['pin']) && !empty($kv['pin'])) {
                        $proxi_id = $kv['pin'];
                    } else if (isset($kv['userpin']) && !empty($kv['userpin'])) {
                        $proxi_id = $kv['userpin'];
                    } else if (isset($kv['userid']) && !empty($kv['userid'])) {
                        $proxi_id = $kv['userid'];
                    }

                    // Extract Time / Date
                    if (isset($kv['time']) && !empty($kv['time'])) {
                        $date_time = $kv['time'];
                    } else if (isset($kv['date']) && !empty($kv['date'])) {
                        $date_time = $kv['date'];
                    }
                } 
                // Mode 2: Positional columns format (e.g. 3012\t2026-10-05 09:57:59)
                else {
                    $parts = preg_split('/\s+/', $line);

                    if (count($parts) >= 2) {
                        if (strtoupper($parts[0]) === 'ATTLOG' || strtoupper($parts[0]) === 'OPERLOG') {
                            array_shift($parts);
                        }

                        if (count($parts) >= 2) {
                            $proxi_id = trim($parts[0]);

                            if (isset($parts[1]) && isset($parts[2]) && preg_match('/^\d{4}[-\/]\d{2}[-\/]\d{2}$/', $parts[1]) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $parts[2])) {
                                $date_time = str_replace('/', '-', $parts[1]) . ' ' . $parts[2];
                            } else if (preg_match('/^\d{4}[-\/]\d{2}[-\/]\d{2} \d{2}:\d{2}:\d{2}$/', $parts[1])) {
                                $date_time = str_replace('/', '-', $parts[1]);
                            }
                        }
                    }
                }

                if (!empty($proxi_id) && $proxi_id !== 'No.' && !empty($date_time)) {
                    $has_punch_data = true;
                    $inserted = $this->insert_attendance_punch($proxi_id, $date_time);
                    if ($inserted) {
                        $processed_count++;
                        $debug_details[] = " -> SUCCESS: Inserted User PIN {$proxi_id} @ {$date_time}";
                    } else {
                        $debug_details[] = " -> SKIPPED: Duplicate or DB error for User PIN {$proxi_id} @ {$date_time}";
                    }
                }
            }
        }

        if (!empty($sn) && $processed_count > 0) {
            $this->db->query("UPDATE iclock_devices SET total_records = total_records + {$processed_count} WHERE sn = " . $this->db->escape($sn));
        }

        // Only log to file if actual punch logs were received in request
        if ($has_punch_data || $processed_count > 0) {
            $extra_log = implode("\n", $debug_details) . "\nTotal processed: {$processed_count}";
            $this->log_debug('cdata (Punch Received)', $extra_log);
        }

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
        echo "OK";
    }

    public function registry() {
        $sn = $this->input->get_post('SN');
        if (empty($sn)) {
            $sn = $this->input->get_post('sn');
        }
        if (!empty($sn)) {
            $this->update_device_info($sn);
        }
        echo "RegistryCode=1\n";
    }

    public function push() {
        echo "OK";
    }

    public function fdata() {
        $sn = $this->input->get_post('SN');
        if (!empty($sn)) {
            $this->update_device_info($sn);
        }
        echo "OK";
    }

    public function query() {
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
            $inserted = $this->db->insert($att_table, $data);
            if ($inserted) {
                $this->run_auto_attn_process($proxi_id, $date_time);
            }
            return $inserted;
        }

        return false;
    }

    /**
     * Trigger attendance process after a punch log is successfully inserted
     */
    private function run_auto_attn_process($proxi_id, $date_time) {
        try {
            $process_date = date('Y-m-d', strtotime($date_time));
            if (empty($process_date)) return;

            $this->load->model('Attn_process_model');

            // Find matching employee by proxi_id
            $emp_info = $this->db->select('emp_id, unit_id')
                                 ->where('proxi_id', $proxi_id)
                                 ->get('pr_emp_com_info')
                                 ->row();

            if (!empty($emp_info)) {
                $grid_emp_id = array($emp_info->emp_id);
                $unit_id = $emp_info->unit_id;
                $this->Attn_process_model->attn_process($process_date, $unit_id, $grid_emp_id);
            } else {
                // Fallback: process by proxi_id directly
                $this->Attn_process_model->attn_process($process_date, null, array($proxi_id));
            }
        } catch (Exception $e) {
            log_message('error', 'ADMS Auto Attn Process Error: ' . $e->getMessage());
        }
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
        $log_file = $this->get_log_file_path();

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
        
        $log_file = $this->get_log_file_path();
        if (file_exists($log_file)) {
            $this->data['log_content'] = file_get_contents($log_file);
        } else {
            $this->data['log_content'] = '';
        }

        $this->data['subview']   = 'attn_report/adms_device_list';
        $this->load->view('layout/template', $this->data);
    }
}


