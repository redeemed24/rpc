<?php

class Searchpoints extends CI_Controller{
    function points(){
        if($this->session->userdata('login')==1){
       $this->load->model('checklist/checklist');
       $this->load->model('faculty/faculty');
       $this->load->model('schoolyear/schoolyear');
       $this->load->model('reports/reports');
       
       $data['totalrecord_data'] = $this->checklist->readrecord($this->input->post('faculty_id'), $this->input->post('school_year')+1); //get total points for each qualification
       $data['faculty_data'] = $this->faculty->selectfaculty($this->input->post('faculty_id')); //get faculty info
       $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['qualification_data'] = $this->checklist->getqual($this->input->post('faculty_id'), $this->input->post('school_year')+1); //get qualification id for that school year
       $data['record_data'] = $this->checklist->getrecord($this->input->post('faculty_id'), $this->input->post('school_year')+1); //get records for that school year inner join qualification table for viewing
       $data['current_schoolyear'] = $this->schoolyear->getschoolyear();
       $data['previous_rank'] = $this->reports->previousrank($this->input->post('faculty_id'), $this->input->post('school_year')+1); //get previous rank
        
       $this->load->view('checklist/editrecord', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>