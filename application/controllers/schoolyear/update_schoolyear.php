<?php

class Update_schoolyear extends CI_Controller{
    
    function updateschoolyear(){
        if($this->session->userdata('login')==1){
        $this->load->model('schoolyear/schoolyear');
        $this->schoolyear->updatesy();
        redirect(base_url().'Rpc/allschoolyear','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>