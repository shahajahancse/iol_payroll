<?php
define('BASEPATH', TRUE);
require_once 'index.php';

$CI =& get_instance();
$CI->load->database();

$sql = "CREATE TABLE IF NOT EXISTS `emp_dasignation_line_acl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  KEY `dept_id` (`dept_id`),
  KEY `section_id` (`section_id`),
  KEY `line_id` (`line_id`),
  KEY `designation_id` (`designation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($CI->db->query($sql)) {
    echo "Table emp_dasignation_line_acl ensured successfully!";
} else {
    echo "Error: " . print_r($CI->db->error(), true);
}
