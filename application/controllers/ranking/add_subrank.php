<?php

class Add_subrank extends CI_Controller{
    function addsubrank($rank_id){
        
	
	if($this->session->userdata('login')==1){
        $this->load->library('form_validation');
	
	$this->load->model('ranking/ranks');
	$this->form_validation->set_rules('min_points', 'max_points', 'callback_diffcheck');
	
	if($this->form_validation->run()==TRUE){
	    $this->form_validation->set_rules('min_points', 'max_points', 'callback_checklimits');
	    if($this->form_validation->run()==TRUE){
	    
            $this->ranks->insertsubrank($rank_id);
	redirect(base_url().'Rpc/loadupdaterank/'.$rank_id,'refresh');
	}
	else{
	    $data['rank_data'] = $this->ranks->getrank($rank_id);
             $this->load->model('schoolyear/schoolyear');
             $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
             $this->load->view('ranking/add_subrank', $data);
	}
	}
        
	else{
	//redirect(base_url().'Rpc/loadaddsubrank/'.$rank_id,'refresh');
	$data['rank_data'] = $this->ranks->getrank($rank_id);
        $this->load->model('schoolyear/schoolyear');
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	$this->load->view('ranking/add_subrank', $data);
        }
        }
	
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    
    function diffcheck($min_points){
	if($this->input->post('min_points')>$this->input->post('max_points')){
	    $this->form_validation->set_message('diffcheck', 'Error: Minimum Points is Greater than the Maximum Points.');
	    return FALSE;
	}
	
	else{
	    return TRUE;
	}
    }
    
    function checklimits($max_points, $min_points){
	$this->load->model('ranking/ranks');
	$ans = $this->ranks->checkexist(0, 1);
	
	if($ans == NULL){
	    return TRUE;
	}
	else{
	    $this->form_validation->set_message('checklimits', 'Error: Values are already existing.');
	    return FALSE;
	}
	
    }
}