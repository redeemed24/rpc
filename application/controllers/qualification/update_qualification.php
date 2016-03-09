<?php

class update_qualification extends CI_Controller{
    function updatequalification()
    {
    if($this->session->userdata('login')==1){
    
    $this->load->model('qualification/qualifications');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('qualification_name', 'qualification_name', 'callback_checkquali');
    
    if($this->form_validation->run()==TRUE){
    
    $this->qualifications->editqualification();
    redirect(base_url().'Rpc/loadviewqualification','refresh');
    }
    else{
       $data['qualification_data'] = $this->qualifications->readqualification($this->input->post('qualification_id')); // get all the list of qualification ids
       $data['item_data'] = $this->qualifications->allitems($this->input->post('qualification_id'));
       $this->load->view('qualifications/update_qualifications', $data);
    }
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function checkquali($qualification_name){
	$this->load->model('qualification/qualifications');
	$ans = $this->qualifications->checkexist($qualification_name, 1, $this->input->post('qualification_id'));
	
	if($ans == NULL){
	    return TRUE;
	}
	else{
	     $this->form_validation->set_message('checkquali', 'Qualification name is already existing.');
	     return FALSE;
	}
    }
}

?>