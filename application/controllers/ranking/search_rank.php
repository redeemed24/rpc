<?php

class Search_rank extends CI_Controller{
    function searchrank(){
        if($this->session->userdata('login')==1){
        $this->load->model('ranking/ranks');
        $data['rank_data'] = $this->ranks->searchrank($this->input->post('keywords'));
        $data['subrank_data'] = $this->ranks->viewsubrank();
        $this->load->model('schoolyear/schoolyear');
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        
        $this->load->view('ranking/view_rank', $data);        
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>