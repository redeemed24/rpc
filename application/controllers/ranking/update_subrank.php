<?php

class Update_subrank extends CI_Controller{
    function updatesubrank($subrank_id){
        if($this->session->userdata('login')==1){
        
	$this->load->model('ranking/ranks');
	if($this->input->post('old_max')!=$this->input->post('max_points') || $this->input->post('old_min')!=$this->input->post('min_points')){
	    
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('min_points', 'max_points', 'callback_diffcheck');
	
	    if($this->form_validation->run()==TRUE){
	    $this->form_validation->set_rules('min_points', 'max_points', 'callback_checklimits');
		if($this->form_validation->run()==TRUE){
		  $this->ranks->updatesubrank($subrank_id);
                  redirect(base_url().'Rpc/loadallrank','refresh');
		}
		else{
		//redirect(base_url().'Rpc/loadupdatesubrank/'.$subrank_id);
                $this->load->model('schoolyear/schoolyear');
                $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
		$data ['subrank_data'] = $this->ranks->getsubrank($subrank_id);
		$data ['rank_data'] = $this->ranks->viewrank();
		$this->load->view('ranking/update_subrank', $data);
		}
	    }
	    
	    else{
		//redirect(base_url().'Rpc/loadupdatesubrank/'.$subrank_id);
                $this->load->model('schoolyear/schoolyear');
                $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
		 $data ['subrank_data'] = $this->ranks->getsubrank($subrank_id);
		 $data ['rank_data'] = $this->ranks->viewrank();
                 $this->load->view('ranking/update_subrank', $data);
	    }
	    }
	
	    else{
	    $this->ranks->updatesubrank($subrank_id);
	    redirect(base_url().'Rpc/loadallrank','refresh');
	    }
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
      function checklimits($max_points, $min_points){
	$this->load->model('ranking/ranks');
	$ans = $this->ranks->checkexist(1, $this->input->post('subrank_id'));
	
	if($ans == NULL){
	    return TRUE;
	}
	else{
	    $this->form_validation->set_message('checklimits', 'Error: Values are already existing.');
	    return FALSE;
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
}
?>