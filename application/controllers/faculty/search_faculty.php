<?php

class Search_faculty extends CI_Controller{
    function search(){
        if($this->session->userdata('login')==1){
        $this->load->model('faculty/faculty');
        $this->load->model('programs/programs');
	$this->load->model('schoolyear/schoolyear');
	
        $data['faculty_data'] = $this->faculty->findfaculty();
	$data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['program_data'] = $this->programs->loadprograms(); // get all the programs
        $this->load->view('faculty/view_faculties', $data);
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function searchrecords(){
        if($this->session->userdata('login')==1){
        $this->load->model('faculty/faculty');
        $this->load->model('schoolyear/schoolyear');
	
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['school_year'] = $this->schoolyear->getschoolyear(); //get current school year
        $data ['faculty_data'] = $this->faculty->searchfaculty();
        $this->load->view('checklist/viewrecords', $data);
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function searchcurrrecord(){
        if($this->session->userdata('login')==1){
        $this->load->model('schoolyear/schoolyear');
        $this->load->model('programs/programs');
        $this->load->model('checklist/checklist');
        
        $data['school_year'] = $this->schoolyear->getthisschoolyear($this->input->post('SY')+1);
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['all_school_year'] = $this->schoolyear->getallschoolyear(); //get school year
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	 
        if($this->session->userdata('userlevel_id')==3){
         $data['assigned_program'] = $this->programs->selectprogram();
         $data ['faculty_data'] = $this->checklist->getmultiplerecord();
        $this->load->view('checklist/multiple_records', $data);
        }
        
        else{
        $data ['faculty_data'] = $this->checklist->searchrecord();
        $this->load->view('checklist/viewrecords', $data);
        }
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function searchonerecord(){
        if($this->session->userdata('login')==1){
        $this->load->model('schoolyear/schoolyear');
        $this->load->model('programs/programs');
        $this->load->model('checklist/checklist');
	
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['school_year'] = $this->schoolyear->getthisschoolyear($this->input->post('SY')+1);
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['all_school_year'] = $this->schoolyear->getallschoolyear(); //get school year
        $data['faculty_data'] = $this->checklist->getthisrecord();
        $this->load->view('checklist/assigned_record', $data);
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>