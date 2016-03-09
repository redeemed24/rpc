<?php

class Notes extends CI_Controller{
    function update_remarks($report_id){
        if($this->session->userdata('login')==1){
        $this->load->model('reports/reports');
        $this->reports->save_remarks($report_id);
        
        redirect(base_url().'Rpc/loadreports','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>