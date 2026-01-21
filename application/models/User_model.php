<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_months()
    {
        $year = $this->session->userdata('session');
        $this->db->select('*');
        $this->db->where('session', $year);
        $query = $this->db->get('month_setup');
        return $query->result_array();
    }

    public function get_months_fees()
    {
        $year = $this->session->userdata('session');
        $this->db->select('*');
        $this->db->where('session', $year);
        $query = $this->db->get('fees_setup');
        return $query->result_array();
    }


    public function getting_fees_by_month($plan)
    {
        try {
            // Retrieve session data
            $session = $this->session->userdata('session');
            // Build the query
            $this->db->select('*');
            $this->db->where('session', $session);
            $this->db->where_in('month', $plan);
            $this->db->from($this->db->dbprefix('fees_setup'));
            $data = $this->db->get()->row_array();
            $db_error = $this->db->error();
            if ($db_error['code'] !== 0) {
                throw new Exception($db_error['message']);
            }
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    // this is all student report
    public function student_details()
    {
        $year = $this->session->userdata('session');
        $this->db->select('*');
        $this->db->where('session', $year);
        $query = $this->db->get('students');
        return $query->result_array();
    }


    public function getting_last_admission_id()
    {
        $this->db->select_max('admission_id');
        $query = $this->db->get('students');
        return $query->row()->admission_id; // returns scalar value
    }


    public function student_details_filtered($name = '', $admission_id = '')
    {
        $this->db->from('students');
        $this->db->where('status', '1');
        if (!empty($name)) {
            $this->db->where('name', $name);
        }
        if (!empty($admission_id)) {
            $this->db->where('admission_id', $admission_id);
        }
        return $this->db->get()->result_array();
    }


    public function studentinactive_filtered($name = '', $admission_id = '')
    {
        $this->db->from('students');
        $this->db->where('status', '0');
        if (!empty($name)) {
            $this->db->where('name', $name);
        }
        if (!empty($admission_id)) {
            $this->db->where('admission_id', $admission_id);
        }
        return $this->db->get()->result_array();
    }



    public function active_students_list()
    {
        $year = $this->session->userdata('session');
        $this->db->select('*');
        $this->db->where('session', $year);
        $this->db->where('status', '1');
        $query = $this->db->get('students');
        return $query->result_array();
    }

    public function inactive_students_list()
    {
        $year = $this->session->userdata('session');
        $this->db->select('*');
        $this->db->where('session', $year);
        $this->db->where('status', '0');
        $query = $this->db->get('students');
        return $query->result_array();
    }





    public function get_student_by_id($admission_id)
    {
        $year = $this->session->userdata('session');
        return $this->db->get_where('students', [
            'admission_id' => $admission_id,
            'session' => $year
        ])->row_array();
    }
}
