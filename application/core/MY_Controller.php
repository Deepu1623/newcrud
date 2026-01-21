<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function theme($view, $data = [])
    {
        $this->load->view('admin/header/header');
        $this->load->view('admin/header/sidebar');

        if (!empty($data)) {
            $this->load->view($view, $data);
        } else {
            $this->load->view($view);
        }

        $this->load->view('admin/header/footer');
    }


    //! Class Ends
}
