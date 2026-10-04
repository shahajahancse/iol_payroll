<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iclock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->database();
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

        // 1. GET Request: Device Handshake / Heartbeat Init
        if ($method === 'GET') {
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

        // 2. POST Request: Attendance Logs Transmission
        $raw_data = file_get_contents('php://input');

        if (empty($raw_data)) {
            $raw_data = isset($_POST['data']) ? $_POST['data'] : '';
        }

        $processed_count = 0;

        if (!empty($raw_data)) {
            $lines = explode("\n", str_replace("\r", "", trim($raw_data)));

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // Typical ZKTeco ADMS ATTLOG line format:
                // PIN \t TIMESTAMP \t STATUS \t VERIFY_TYPE ...
                // e.g. "3011\t2026-10-04 17:10:05\t0\t1\t0\t0\t0"
                $parts = preg_split('/\s+/', $line);

                if (count($parts) >= 2) {
                    $proxi_id = trim($parts[0]);

                    // Check if second and third parts form a date & time string
                    if (isset($parts[1]) && isset($parts[2]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $parts[1]) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $parts[2])) {
                        $date_time = $parts[1] . ' ' . $parts[2];
                    } else if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $parts[1])) {
                        $date_time = $parts[1];
                    } else {
                        // Skip invalid header / non-log line
                        continue;
                    }

                    if (!empty($proxi_id) && $proxi_id !== 'No.' && !empty($date_time)) {
                        if ($this->insert_attendance_punch($proxi_id, $date_time)) {
                            $processed_count++;
                        }
                    }
                }
            }
        }

        if (!empty($sn) && $processed_count > 0) {
            $this->db->query("UPDATE iclock_devices SET total_records = total_records + {$processed_count} WHERE sn = " . $this->db->escape($sn));
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
        echo "OK";
    }

    public function push() {
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
     * Admin view page to monitor connected ZKTeco ADMS devices
     */
    public function device_list() {
        $this->data['devices'] = $this->db->order_by('last_activity', 'DESC')->get('iclock_devices')->result();
        $this->data['title'] = 'ADMS Devices';
        $this->data['subview'] = 'attn_report/adms_device_list';
        $this->load->view('layout/template', $this->data);
    }
}
