<?php

class Update_program extends CI_Controller{
    function updateprogram($id){
    if($this->session->userdata('login')==1){
    $this->load->model('schoolyear/schoolyear');
    
    $this->load->library('form_validation');
	
    $this->form_validation->set_rules('program_name', 'program_name', 'callback_checkprogram');
	
    if($this->form_validation->run()==TRUE){
    $this->load->model('programs/programs');
    $this->programs->updateprogram($id);
    $data['program_data'] = $this->programs->getlistprogram();
    $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
    $this->load->view('program/view_program', $data);
    }
    
    else{
    $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
    $this->load->view('program/add_program', $data);
    }
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
     function checkprogram($program){
	$this->load->model('programs/programs');
	$ans = $this->programs->checkprogram($program, 0, $this->input->post('program_id'));
	
	if($ans == NULL){
	    return TRUE;
	}
	else{
	    $this->form_validation->set_message('checkprogram', 'Program name is already existing.');
	    return FALSE;
	}
    }
}
?>