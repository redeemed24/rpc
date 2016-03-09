<?php

class add_qualification extends CI_Controller{
    function addqualification()
    {
    if($this->session->userdata('login')==1){    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('qualification_name', 'qualification_name', 'callback_checkquali');
    
    if($this->form_validation->run()==TRUE){
    $this->load->model('qualification/qualifications');
    $this->qualifications->insertqualification();
    redirect(base_url().'Rpc/loadviewqualification','refresh');
    }
    else{
	 $this->load->model('schoolyear/schoolyear');
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	$this->load->view('qualifications/add_qualifications', $data);
    }
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function checkquali($qualification_name){
	$this->load->model('qualification/qualifications');
	$ans = $this->qualifications->checkexist($qualification_name, 0, 1);
	
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