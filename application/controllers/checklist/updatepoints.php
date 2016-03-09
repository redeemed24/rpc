<?php

class Updatepoints extends CI_Controller{
    function points(){
        if($this->session->userdata('login')==1){
        $this->load->model('checklist/checklist');
        $this->load->model('reports/reports');
        $this->checklist->updatepoints();
        $this->checklist->updaterecord();
        $this->reports->updatereport();
        redirect(base_url().'Rpc/loadallfacultiesrecords','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}