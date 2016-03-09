<?php

class Add_item extends CI_Controller{
    function additem(){
        
        if($this->session->userdata('login')==1){
        if($this->input->post('item_name')!=NULL){
        $this->load->model('qualification/qualifications');
        $this->qualifications->insertitem();
        }
        
        redirect(base_url().'Rpc/loadupdatequalification/'.$this->input->post('qual_id'),'refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>