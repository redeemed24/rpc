<?php

class Savepoints extends CI_Controller{
    function points(){
       if($this->session->userdata('login')==1){
       $this->load->model('checklist/checklist');
       $this->load->model('reports/reports');
       $this->load->model('faculty/faculty');
       
       $this->faculty->setrecord($this->input->post('faculty_id'));
       $this->checklist->insertpoints();
       $this->checklist->insertrecord();
       $this->reports->insertreport();
       redirect(base_url().'Rpc/listchecklist','refresh');
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>