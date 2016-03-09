<?php

class Add_rank extends CI_Controller{
    function addrank(){
        if($this->session->userdata('login')==1){
        
        $this->load->model('ranking/ranks');
        $this->load->model('degree/degree');
	
	$this->load->library('form_validation');
	$this->form_validation->set_rules('rank_name', 'rank_name', 'callback_checkrank');
	
	if($this->form_validation->run()==TRUE){
	$this->ranks->insertrank();
        redirect(base_url().'Rpc/loadallrank','refresh');
	}
	else{
	     $data['degree_data'] = $this->degree->readdegree(); // get all the degree
	     $this->load->model('schoolyear/schoolyear');
             $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
             $this->load->view('ranking/add_rank', $data);
	}
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function checkrank($rank_name){
	$this->load->model('ranking/ranks');
        $ans = $this->ranks->searchrank($rank_name);
	
	if($ans==NULL){
	    return TRUE;
	}
	else{
	    $this->form_validation->set_message('checkrank', 'Error: Rank name is already existing.');
	    return FALSE;
	}
    }
}
?>