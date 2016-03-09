<?php

class Delete_item extends CI_Controller{
    function deleteitem(){
        if($this->session->userdata('login')==1){
        $this->load->model('qualification/qualifications');
        $this->qualifications->removeitem();
        redirect(base_url().'Rpc/loadviewqualification','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function deletequalification(){
        if($this->session->userdata('login')==1){
        $this->load->model('qualification/qualifications');
        $this->qualifications->removequalification();
        redirect(base_url().'Rpc/loadviewqualification','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>