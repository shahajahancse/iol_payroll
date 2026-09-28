<?php
class Monitoring_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);

		$this->load->model('Common_model');
        $this->load->model('Monitoring_model');

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
	}

    // employee resign entry system start
	public function resign_list()
    {
        $this->db->select('
            com.emp_id,com.emp_join_date,com.gross_sal,
            per.name_en,per.father_name,per.mother_name,per.img_source,
            per.personal_mobile,per.emp_dob,per.gender,per.marital_status,
            dg.desig_name,line.line_name_en, resign.resign_date
        ');
        $this->db->from('pr_emp_resign_history resign');
        $this->db->join('pr_emp_com_info com', 'com.emp_id = resign.emp_id', 'left');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = com.emp_id', 'left');
        $this->db->join('emp_line_num line', 'line.id = com.emp_line_id', 'left');
        $this->db->join('emp_designation dg', 'dg.id = com.emp_desi_id', 'left');
        $this->data['results'] = $this->db->where('resign.monitor_con', 2)->get()->result();
        $this->data['title'] = 'Resign List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'monitoring/resign_list';
        $this->load->view('layout/template', $this->data);
    }

	public function approve_resign()
    {
        $emp_id = $this->input->post('emp_id');
        $this->db->trans_start();
        $data = array(
            'monitor_con' => 1,
            'monitor_id' => $this->data['user_data']->id,
            'monitor_date' => date('Y-m-d')
        );
        $this->db->where('emp_id', $emp_id)->update('pr_emp_resign_history', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }

    public function delete_resign()
    {
        $emp_id = $this->input->post('emp_id');

        $this->db->trans_start();
        $this->db->where('emp_id', $emp_id)->delete('pr_emp_resign_history');
        $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', array('emp_cat_id' => 1));
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }
    // employee resign entry system end

    // employee left entry system start
	public function left_list()
    {
        $this->db->select('
            com.emp_id,com.emp_join_date,com.gross_sal,
            per.name_en,per.father_name,per.mother_name,per.img_source,
            per.personal_mobile,per.emp_dob,per.gender,per.marital_status,
            dg.desig_name,line.line_name_en, left.left_date
        ');
        $this->db->from('pr_emp_left_history left');
        $this->db->join('pr_emp_com_info com', 'com.emp_id = left.emp_id', 'left');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = com.emp_id', 'left');
        $this->db->join('emp_line_num line', 'line.id = com.emp_line_id', 'left');
        $this->db->join('emp_designation dg', 'dg.id = com.emp_desi_id', 'left');
        $this->data['results'] = $this->db->where('left.monitor_con', 2)->get()->result();
        $this->data['title'] = 'Left List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'monitoring/left_list';
        $this->load->view('layout/template', $this->data);
    }

	public function approve_left()
    {
        $emp_id = $this->input->post('emp_id');
        $this->db->trans_start();
        $data = array(
            'monitor_con' => 1,
            'monitor_id' => $this->data['user_data']->id,
            'monitor_date' => date('Y-m-d')
        );
        $this->db->where('emp_id', $emp_id)->update('pr_emp_left_history', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }

    public function delete_left()
    {
        $emp_id = $this->input->post('emp_id');

        $this->db->trans_start();
            $this->db->where('emp_id', $emp_id)->delete('pr_emp_left_history');
            $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', array('emp_cat_id' => 1));
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }
    // employee left entry system end

    // employee Increment/Promotion/Line change system start
	public function emp_inc_list()
    {
        $this->db->select('
            com.emp_id,com.emp_join_date, per.name_en,
            ipp.prev_salary,ipp.new_salary,ipp.effective_month,ipp.status,
            line.line_name_en,dg.desig_name, linen.line_name_en new_line, dgn.desig_name new_desig
        ');
        $this->db->from('pr_incre_prom_pun ipp');
        $this->db->join('pr_emp_com_info com', 'com.emp_id = ipp.ref_id', 'left');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = com.emp_id', 'left');

        $this->db->join('emp_line_num line', 'line.id = ipp.prev_line', 'left');
        $this->db->join('emp_designation dg', 'dg.id = ipp.prev_desig', 'left');
        $this->db->join('emp_line_num linen', 'linen.id = ipp.new_line', 'left');
        $this->db->join('emp_designation dgn', 'dgn.id = ipp.new_desig', 'left');
        $this->data['results'] = $this->db->where('ipp.monitor_con', 2)->get()->result();
        // dd($this->data['results']);
        $this->data['title'] = 'Employee List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'monitoring/emp_inc_list';
        $this->load->view('layout/template', $this->data);
    }

	public function approve_emp_ipl()
    {
        $emp_id = $this->input->post('emp_id');
        $effective_month = $this->input->post('effective_month');
        $this->db->trans_start();
        $data = array(
            'monitor_con' => 1,
            'monitor_id' => $this->data['user_data']->id,
            'monitor_date' => date('Y-m-d')
        );
        $this->db->where('ref_id', $emp_id)->where('effective_month', $effective_month)->update('pr_incre_prom_pun', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }

    public function delete_emp_ipl()
    {
        $emp_id = $this->input->post('emp_id');
        $effective_month = $this->input->post('effective_month');
        $r = $this->db->where('ref_id', $emp_id)->where('effective_month', $effective_month)->get('pr_incre_prom_pun')->row();

        $this->db->trans_start();
        $data = array(
            'emp_dept_id'    => $r->prev_dept,
            'emp_sec_id'     => $r->prev_section,
            'emp_line_id'    => $r->prev_line,
            'emp_desi_id'    => $r->prev_desig,
            'gross_sal'      => $r->prev_salary,
            'com_gross_sal'  => $r->prev_com_salary,
            'emp_sal_gra_id' => $r->prev_grade
        );
        if ($this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $data)) {
            $this->db->where('ref_id', $emp_id)->where('effective_month', $effective_month)->delete('pr_incre_prom_pun');
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }
    // employee Increment/Promotion/Line change system end

    // employee entry system start
	public function emp_list()
    {
        $this->db->select('
            com.emp_id,com.emp_join_date,com.gross_sal,
            per.name_en,per.father_name,per.mother_name,per.img_source,
            per.personal_mobile,per.emp_dob,per.gender,per.marital_status,
            dg.desig_name,line.line_name_en
        ');
        $this->db->from('pr_emp_com_info com');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = com.emp_id', 'left');
        $this->db->join('emp_line_num line', 'line.id = com.emp_line_id', 'left');
        $this->db->join('emp_designation dg', 'dg.id = com.emp_desi_id', 'left');
        $this->data['results'] = $this->db->where('com.monitor_con', 2)->get()->result();
        // dd($this->data['results']);
        $this->data['title'] = 'Employee List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'monitoring/emp_list';
        $this->load->view('layout/template', $this->data);
    }

	public function approve_emp()
    {
        $emp_id = $this->input->post('emp_id');
        $this->db->trans_start();
        $data = array(
            'monitor_con' => 1,
        );
        $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }

    public function delete_emp()
    {
        $emp_id = $this->input->post('emp_id');

        $this->db->trans_start();
        $this->db->where('emp_id', $emp_id)->delete('pr_emp_com_info');
        $this->db->where('emp_id', $emp_id)->delete('pr_emp_per_info');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }
    // employee entry system end

    // manual attendance entry start
	public function entry_list()
    {
        $last_month = array();
        $date = date("Y-m-d");
        if ($date < date('Y-m-15')) {
            $attn_table = "att_".date("Y_m", strtotime('-1 month', strtotime(date("Y-m-d"))));
            $last_month = $this->db->where('monitor_con', 2)->get($attn_table)->result();
        }
        $attn_table = "att_".date("Y_m");
        $current_data = $this->db->where('monitor_con', 2)->order_by('date_time', 'desc')->get($attn_table)->result();
        $results = array_merge($last_month, $current_data);
        usort($results, fn($a,$b) => strtotime($b->date_time) <=> strtotime($a->date_time));
        $this->data['results'] = $results;

        $this->data['title'] = 'Training List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'monitoring/entry_list';
        $this->load->view('layout/template', $this->data);
    }

	public function approves()
    {
        $att_id = $this->input->post('id');
        $date_time = $this->input->post('date_time');
        $attn_table = "att_".date("Y_m", strtotime($date_time));
        $this->db->trans_start();
        $data = array(
            'monitor_con' => 1,
            'monitor_id' => $this->data['user_data']->id,
            'monitor_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $att_id)->update($attn_table, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }

	public function deletes()
    {
        $att_id = $this->input->post('id');
        $date_time = $this->input->post('date_time');
        $attn_table = "att_".date("Y_m", strtotime($date_time));

        $this->db->trans_start();
        $this->db->where('att_id', $att_id)->delete($attn_table);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'success';
        }
    }
    // manual attendance entry end
}
