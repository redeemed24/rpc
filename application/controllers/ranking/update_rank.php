<?php

class Update_rank extends CI_Controller{
    function updaterank($rank_id){
        if($this->session->userdata('login')==1){
        $this->load->model('ranking/ranks');
	
	$this->load->model('degree/degree');
	
	$this->load->library('form_validation');
	$this->form_validation->set_rules('rank_name', 'rank_name', 'callback_checkrank');
	
	if($this->form_validation->run()==TRUE){
        $this->ranks->updaterank($rank_id);
        redirect(base_url().'Rpc/loadallrank','refresh');
	}
	else{
	     $data ['subrank_data'] = $this->ranks->selectsubrank($rank_id);
             $data['rank_data'] = $this->ranks->getrank($rank_id);
             $data['degree_data'] = $this->degree->readdegree(); // get all the degree
            $this->load->model('schoolyear/schoolyear');
            $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
            
             $this->load->view('ranking/update_rank', $data);
	}
        }
	else{
	    $this->load->view('loginpage');  
	}

    }
    
     function checkrank($rank_name){
	$this->load->model('ranking/ranks');
        $ans = $this->ranks->isrank($rank_name, $this->input->post('rank_id'));
	
	if($ans==NULL){
	    return TRUE;
	}
	else{
	    $this->form_validation->set_message('checkrank', 'Error: Rank name is already existing.');
	    return FALSE;
	}
    }
    
    function removesubrank(){
        if($this->session->userdata('login')==1){
        $this->load->model('ranking/ranks');
        $this->ranks->removesubrank();
        redirect(base_url().'Rpc/loadallrank','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}

    }
    
    function removerank(){
        if($this->session->userdata('login')==1){
        $this->load->model('ranking/ranks');
        $this->ranks->removerank();
        redirect(base_url().'Rpc/loadallrank','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}

    }
}

?>