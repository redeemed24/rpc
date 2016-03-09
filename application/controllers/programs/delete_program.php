<?php

class Delete_program extends CI_Controller{
    function deleteprogram(){
        if($this->session->userdata('login')==1){
        $this->load->model('programs/programs');
        $this->programs->removeprogram();
        redirect(base_url().'Rpc/loadallprogram','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>