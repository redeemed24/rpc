<?php

class Search_user extends CI_Controller{
    function search(){
        if($this->session->userdata('login')==1){

        $this->load->model('users/user');
        $this->load->model('schoolyear/schoolyear');
        
        $data['allusers_data'] = $this->user->searchuser();
        $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        
        if($this->session->userdata('userlevel_id')==1 || $this->session->userdata('userlevel_id')==2){
        $this->load->view('users/view_users', $data);
        }
        
        else if($this->session->userdata('userlevel_id')==4){
        $this->load->view('users/allusers_superuser', $data);    
        }
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function searchcommittee(){
        if($this->session->userdata('login')==1){
        $this->load->model('users/user');
        $this->load->model('schoolyear/schoolyear');
        
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['allusers_data'] = $this->user->searchcom();
        $this->load->view('users/all_committee', $data);
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
}

?>