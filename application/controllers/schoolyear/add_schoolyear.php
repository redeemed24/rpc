<?php

class Add_schoolyear extends CI_Controller{
    function addschoolyear(){
        if($this->session->userdata('login')==1){
       
        $this->load->model('schoolyear/schoolyear');
        $this->schoolyear->insertschoolyear();
        
        
        redirect(base_url().'Rpc/allschoolyear','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}

?>