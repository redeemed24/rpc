<?php

class Set_schoolyear extends CI_Controller{
    function set($old, $new){
        if($this->session->userdata('login')==1){
        $this->load->model('schoolyear/schoolyear');
        $this->load->model('faculty/faculty');
        
        $this->faculty->setrecordstatus();
        $this->schoolyear->setschoolyear1($old);
        $this->schoolyear->setschoolyear2($new);
        redirect(base_url().'Rpc/allschoolyear','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>