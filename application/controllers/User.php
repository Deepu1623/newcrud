<?php

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('common_helper');
    }

    public function registration()
    {
        $this->load->view('admin/login/login');
    }

    public function register()
    {
        // Get the userID and password from the request
        $userID = $this->input->post('userID');
        $password = $this->input->post('password');
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $year = date('Y');
        // Check if userID already exists
        $this->db->where('userid', $userID);
        $query = $this->db->get('user_registration');

        if ($query->num_rows() > 0) {
            // User ID already exists
            echo "exists";
            return;
        }

        // Prepare the data array
        $data = array(
            'userid' => $userID,
            'password' => $password,
            'number' => $phone,
            'name' => $name,
            'email' => $email,
            'session' => $year,
        );

        // Insert the new user data
        $insert = $this->db->insert('user_registration', $data);

        // Check if the insert was successful
        if ($insert) {
            $this->session->set_userdata('name', $name);
            $this->session->set_userdata('userid', $userID);
            $this->session->set_userdata('session', $year);


            echo "success";
        } else {
            echo "failed!";
        }
    }


    public function loginpage()
    {
        $this->load->view('admin/login/login_page');
    }



    public function login()
    {
        $userID = $this->input->post('userID');
        $password = $this->input->post('password');

        $this->db->where('userid', $userID);
        $this->db->where('password', $password);
        $query = $this->db->get('user_registration');
        $year = date('Y');

        if ($query->num_rows() > 0) {
            $this->session->set_userdata('userID', $userID);
            $this->session->set_userdata('session', $year);
            echo "success";
        } else {
            echo "invalid"; // User ID or Password does not match
        }
    }



    public function dashboard()
    {
        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['students'] = $this->User_model->student_details();
            $this->theme('admin/dashboard/dashboard', $data);
        }
    }



    public function get_students()
    {
        $students = $this->User_model->student_details();  // DB se data
        header('Content-Type: application/json');
        echo json_encode($students);
    }


    public function fee_setup()
    {

        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['months'] = $this->User_model->get_months();
            $data['month_fees'] = $this->User_model->get_months_fees();

            $this->theme("admin/fees/fee_setup", $data);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('userID'); // remove user session
        $this->session->sess_destroy(); // destroy entire session if needed
        redirect('index.php'); // redirect to home page
    }


    public function month_setup()
    {
        $userID = $this->session->userdata('userID');
        $months_setup = $this->input->post('months_setup');
        $year = date('Y');
        $this->db->where('month', $months_setup);
        $query = $this->db->get('month_setup');

        if ($query->num_rows() > 0) {
            echo "exists";
            return;
        }
        // Prepare the data array
        $data = array(
            'upload_by' => $userID,
            'month' => $months_setup,
            'session' => $year,
        );
        // Insert the new user data
        $insert = $this->db->insert('month_setup', $data);
        // Check if the insert was successful
        if ($insert) {
            echo "success";
        } else {
            echo "failed!";
        }
    }


    public function fees_adding()
    {
        $userID = $this->session->userdata('userID');
        $months = $this->input->post('months');
        $fees = $this->input->post('fees');

        $year = date('Y');
        $this->db->where('month', $months);
        $query = $this->db->get('fees_setup');

        if ($query->num_rows() > 0) {
            echo "exists";
            return;
        }
        // Prepare the data array
        $data = array(
            'upload_by' => $userID,
            'month' => $months,
            'fees' => $fees,
            'session' => $year,
        );
        // Insert the new user data
        $insert = $this->db->insert('fees_setup', $data);
        // Check if the insert was successful
        if ($insert) {
            echo "success";
        } else {
            echo "failed!";
        }
    }


    //delete months names
    public function deleteMonthNames()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $srno = $_REQUEST['srno'];
        $this->db->where('srno', $srno);
        $del = $this->db->delete($this->db->dbprefix('month_setup'));
        if ($del == true) {
            echo "success";
        } else {
            echo "failed";
        }
    }

    //delete fees data with months
    public function DeleteFeeData()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $srno = $_REQUEST['srno'];
        $this->db->where('srno', $srno);
        $del = $this->db->delete($this->db->dbprefix('fees_setup'));
        if ($del == true) {
            echo "success";
        } else {
            echo "failed";
        }
    }



    public function student_admission()
    {

        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['months'] = $this->User_model->get_months();
            $this->theme("admin/admission/std_admission", $data);
        }
    }



    public function getting_fees_by_month()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $plan = $this->input->post('plan');
        $fee = $this->User_model->getting_fees_by_month($plan);

        if ($fee !== null) {
            echo $fee['fees'];
        } else {
            echo 0; // Or some default/fallback
        }
    }


    public function new_student_admission()
    {
        $userID = $this->session->userdata('userID');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $number = $this->input->post('number');
        $plan = $this->input->post('plan');
        $fees = $this->input->post('fees');
        $gender = $this->input->post('gender');

        $year = date('Y');
        $this->db->where('name', $name);
        $this->db->where('number', $number);
        $query = $this->db->get('students');
        if ($query->num_rows() > 0) {
            echo "exists";
            return;
        }

        $last_admission = $this->User_model->getting_last_admission_id();

        if (!empty($last_admission)) {
            $admission_id = $last_admission + 1;
        } else {
            $admission_id = 1;
        }



        // Prepare the data array
        $student_array = array(
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'plan' => $plan,
            'number' => $number,
            'fees' => $fees,
            'gender' => $gender,
            'created_by' => $userID,
            'session' => $year,
            'admission_id' => $admission_id,

        );

        // Insert the new user student_array
        $insert = $this->db->insert('students', $student_array);
        // Check if the insert was successful
        if ($insert) {
            echo "success";
        } else {
            echo "failed!";
        }
    }


    public function student_report()
    {

        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['students'] = $this->User_model->active_students_list();
            $this->theme("admin/admission/student_report", $data);
        }
    }


    public function get_students_ajax()
    {
        $name = $this->input->post('name');
        $admission_id = $this->input->post('admission_id');

        $students = $this->User_model->student_details_filtered($name, $admission_id);

        $data = [];
        $i = 1;
        foreach ($students as $student) {
            $data[] = [
                'srno' => $i++,
                'admission_id' => $student['admission_id'],
                'name' => strtoupper($student['name']),
                'number' => $student['number'],
                'plan' => strtoupper($student['plan']),
                'fees' => $student['fees'],
                'created_at' => $student['created_at'],
                'action' => '
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                        <a href="' . base_url("index.php/User/view_profile/" . $student['admission_id']) . '" class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i></a>
                        <a href="' . base_url("index.php/User/edit_student/" . $student['admission_id']) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>
                        <a href="' . base_url("admin/student/collect_fees/" . $student['admission_id']) . '" class="btn btn-sm btn-success" title="Collect Fees"><i class="fa fa-inr"></i></a>
                       <a href="javascript:void(0);" 
                            class="btn btn-sm toggle-status-btn ' . ($student['status'] == 1 ? 'btn-outline-danger' : 'btn-outline-secondary') . '" 
                            title="' . ($student['status'] == 1 ? 'Deactivate' : 'Activate') . '" 
                            data-id="' . $student['admission_id'] . '" 
                            data-status="' . $student['status'] . '">
                            <i class="fa ' . ($student['status'] == 1 ? 'fa-toggle-on' : 'fa-toggle-off') . '"></i>
                        </a>
                    </div>'

            ];
        }

        echo json_encode(['data' => $data]);
    }



    //change the student status
    public function toggle_status()
    {
        $admission_id = $this->input->post('admission_id');
        $user_id = $this->session->userdata('userID');
        $year = $this->session->userdata('session');
        $current_date = date('Y-m-d');
        if ($admission_id) {
            // Get current student data
            $this->db->where('admission_id', $admission_id);
            $this->db->where('session', $year);
            $student = $this->db->get('students')->row_array();

            if ($student) {
                $new_status = $student['status'] == 1 ? 0 : 1;


                // Update status directly from controller
                $this->db->where('admission_id', $admission_id);
                $this->db->where('session', $year);
                $this->db->update('students', ['status' => $new_status, 'inactive_by' => $user_id, 'inactive_at' => $current_date]);

                echo json_encode([
                    'success' => true,
                    'new_status' => $new_status,
                    'inactive_by' => $user_id,
                ]);
                return;
            }
        }

        echo json_encode(['success' => false]);
    }



    public function view_profile($admission_id)
    {

        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['students'] = $this->User_model->get_student_by_id($admission_id);
            $this->theme("admin/admission/view_profile", $data);
        }
    }


    public function edit_student($admission_id)
    {

        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['students'] = $this->User_model->get_student_by_id($admission_id);
            $data['months'] = $this->User_model->get_months(); // if you load months dynamically

            $this->theme("admin/admission/edit_student", $data);
        }
    }



    public function update_student_ajax()
    {
        $admission_id = $this->input->post('admission_id');
        $year = $this->session->userdata('session');
        $user_id = $this->session->userdata('userID');
        $current_date = date('Y-m-d');

        $name = strtolower($this->input->post('name'));
        $number = $this->input->post('number');


        $year = date('Y');
        $this->db->where('name', $name);
        $this->db->where('number', $number);
        $query = $this->db->get('students');
        if ($query->num_rows() > 0) {
            echo "exists";
            return;
        }

        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'number' => $this->input->post('number'),
            'gender' => $this->input->post('gender'),
            'plan' => $this->input->post('plan'),
            'fees' => $this->input->post('fees'),
            'updated_by' => $user_id,
            'updated_at' => $current_date,
        );

        $this->db->where('admission_id', $admission_id);
        $this->db->where('session', $year);
        $update = $this->db->update('students', $data);

        echo $update ? "success" : "failed";
    }


    public function inactive_students()
    {

        $user_id = $this->session->userdata('userID');

        if (empty($user_id)) {
            redirect('User/loginpage');
        } else {
            $data['students'] = $this->User_model->inactive_students_list();
            $this->theme("admin/admission/inactive_students", $data);
        }
    }

    public function get_inactive_student_ajax()
    {
        $name = $this->input->post('name');
        $admission_id = $this->input->post('admission_id');

        $students = $this->User_model->studentinactive_filtered($name, $admission_id);

        $data = [];
        $i = 1;
        foreach ($students as $student) {
            $data[] = [
                'srno' => $i++,
                'admission_id' => $student['admission_id'],
                'name' => strtoupper($student['name']),
                'number' => $student['number'],
                'plan' => strtoupper($student['plan']),
                'fees' => $student['fees'],
                'inactive_by' => $student['inactive_by'],
                'inactive_at' => $student['inactive_at'],
                'action' => '
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                        <a href="' . base_url("index.php/User/view_profile/" . $student['admission_id']) . '" class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i></a>                        
                       <a href="javascript:void(0);" 
                            class="btn btn-sm toggle-status-btn ' . ($student['status'] == 1 ? 'btn-outline-danger' : 'btn-outline-secondary') . '" 
                            title="' . ($student['status'] == 1 ? 'Deactivate' : 'Activate') . '" 
                            data-id="' . $student['admission_id'] . '" 
                            data-status="' . $student['status'] . '">
                            <i class="fa ' . ($student['status'] == 1 ? 'fa-toggle-on' : 'fa-toggle-off') . '"></i>
                        </a>
                    </div>'

            ];
        }

        echo json_encode(['data' => $data]);
    }
}
