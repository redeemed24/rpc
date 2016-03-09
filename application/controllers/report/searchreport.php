<?php

class Searchreport extends CI_Controller{
    
    function readreport(){
        if($this->session->userdata('login')==1){
        $this->load->model('schoolyear/schoolyear');
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        if($this->input->post('program')==0){
            $data['records'] = array('val'=>0);
        }
        
        else{
            $data['records'] = array('val'=>1);
        }
        
        if($this->input->post('keywords')!=NULL){
            $data['keywords'] = array('val'=>1);
        }
        
        else{
            $data['keywords'] = array('val'=>0);
        }
        
        if($this->session->userdata('userlevel_id')==1){
        $this->load->model('reports/reports');
        $this->load->model('programs/programs');
       
       
        $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['report_data'] = $this->reports->loadallreport();
        $this->load->view('report/view_reports', $data);
        }
        
        else if($this->session->userdata('userlevel_id')==2){
        $this->load->model('reports/reports');
        $this->load->model('programs/programs');
       
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['report_data'] = $this->reports->loadallreportforchair();
        $this->load->view('report/chair_reports', $data);
        }
        
        else if($this->session->userdata('userlevel_id')==3){
        $this->load->model('reports/reports');
        $this->load->model('programs/programs');
        $this->load->model('schoolyear/schoolyear');
       
        $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        
            if($this->input->post('check')==1){
            $data['report_data'] = $this->reports->loadreportassign();
            $this->load->view('report/assigned_reports', $data);
            }
            
            else{
            $data['assigned_program'] = $this->programs->selectprogram();
            $data['report_data'] = $this->reports->loadmultiplereports();
            $this->load->view('report/multiple_reports', $data);
            }
        }
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
     
    function individual($faculty_id, $sy_id){
        if($this->session->userdata('login')==1){
        $this->load->model('reports/reports');
        $this->load->model('checklist/checklist');
        $this->load->model('schoolyear/schoolyear');
        
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['updated_data'] = $this->reports->getupdate($faculty_id, $sy_id);
        $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
        $data['record_data'] = $this->checklist->readrecord($faculty_id, $sy_id);
        $data['individual_data']= $this->reports->individualrep($faculty_id, $sy_id);
        $this->load->view('report/view_individualrep', $data);
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function retrieverecord($faculty_id){
        if($this->session->userdata('login')==1){
        $sy_id = $this->input->post('SY');
        
        $this->load->model('reports/reports');
        $this->load->model('checklist/checklist');
        $this->load->model('schoolyear/schoolyear');
        $this->load->model('faculty/faculty');
        
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['updated_data'] = $this->reports->getupdate($faculty_id, $sy_id);
        $data['faculty_data']= $this->faculty->selectfaculty($faculty_id);
        $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
        $data['record_data'] = $this->checklist->readrecord($faculty_id, $sy_id);
        $data['individual_data']= $this->reports->individualrep($faculty_id, $sy_id);
        $this->load->view('report/view_individualrep', $data);
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}

?>