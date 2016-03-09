<?php

class Checklist extends CI_Model{
    function insertpoints(){
        
        for($x=1; $x<=$this->db->get('item')->num_rows(); $x++){ //Check
            $data = array('item_id'=>$this->input->post($x."id"),
                          'points'=>$this->input->post($x), 'sy_id'=>$this->input->post('sy_id'),
                          'faculty_id'=>$this->input->post('faculty_id'));
            
            if($x==$this->input->post($x."id")){
            $this->db->insert('sample', $data); }
        }
    }
    
    function insertrecord(){ //Computes and Inserts total record of items for each qualification to the database
        $this->load->model('qualification/qualifications');
        $qualification=$this->qualifications->getqualifications();
        $item = $this->qualifications->getitems();
        
        foreach($qualification as $row1){
            $sum=0;
            foreach($item as $row2){
                if($row1->qualification_id == $row2->qualification_id){
                    for($x=1; $x<=$this->db->get('item')->num_rows(); $x++){ 
                        if($row2->item_id==$this->input->post($x."id")){
                        $sum = $sum + $this->input->post($x);
                        }
                    }
                }
            }
            
            if($sum>$row1->maxpoints){
                $sum = $row1->maxpoints;
            }
            
            $percentage = ($row1->maxpercentage/100);
            
            $data= array('qualification_id'=>$row1->qualification_id,
                         'points_earned'=>$sum,
                         'points_percent'=>$sum*$percentage,
                         //'points_percent'=>$sum*($row1->maxpercentage."%"),
                         'faculty_id'=>$this->input->post('faculty_id'),
                         'sy_id'=>$this->input->post('sy_id'));
            
            $this->db->insert('record', $data);
       }
    }
    
    function readrecord($faculty_id, $sy_id){ //get total points earned
        $this->db->from('record');
        $this->db->join('qualification', 'qualification.qualification_id = record.qualification_id');
        $this->db->where('faculty_id', $faculty_id);
        $this->db->where('SY_id', $sy_id);
        return $this->db->get()->result();
    }
    
    function updatepoints(){
        for($x=1; $x<=$this->db->get('sample')->num_rows(); $x++){
            $data = array('points'=> $this->input->post($x));
            
            if($x==$this->input->post($x."checklist_id")){
                $this->db->where('checklist_id', $this->input->post($x."checklist_id"));
                $this->db->update('sample', $data);
            }
        }
    }
    
     
    function updaterecord(){ //Computes and Updates total record of items for each qualification to the database
    $qualification = $this->getqual($this->input->post('faculty_id'), $this->input->post('sy_id'));
    $item = $this->getrecord($this->input->post('faculty_id'), $this->input->post('sy_id'));
    
        foreach($qualification as $row1){
        //echo "</br>".$row1->qualification_id."</br>";
            $sum=0;
            foreach($item as $row2){
                if($row2->qualification_id == $row1->qualification_id){
                    //echo $row2->item_id."</br>";
                    $sum = $sum + $row2->points;
                }
            }
            
            if($sum>$row1->maxpoints){
                $sum = $row1->maxpoints;
            }
            
            $percentage = ($row1->maxpercentage/100);
            $data = array('points_earned'=>$sum, 'points_percent'=>$sum*$percentage
                          /*'points_percent'=>$sum*$percentage*/ );
            $this->db->where('faculty_id', $this->input->post('faculty_id'));
            $this->db->where('SY_id', $this->input->post('sy_id'));
            $this->db->where('qualification_id', $row1->qualification_id);
            $this->db->update('record', $data);
        }
    }
    
    function getfaculties($a, $b){
        /*$query = "SELECT program_id from program WHERE 'user_username'=$user_username";
        $this->db->where('status', 1);
        $this->db->where('record_status', 0);
        $this->db->where_in('program_id', $query);*/
        
        $user_username = $this->session->userdata('username');   
        
        if($b==NULL){
            $b=0;
        }
        
        $query = $this->db->query("SELECT * FROM faculty where program_id in(SELECT program_id FROM program where user_username = '$user_username') AND status = '1' AND record_status = '0' ORDER BY faculty_lname ASC LIMIT $b, $a");
        return $query->result();
    }
    
    function getqual($faculty_id, $syid){ //select distinct record of qualification
	$this->db->select('item.qualification_id, qualification.qualification_name, qualification.maxpoints, qualification.maxpercentage');
        $this->db->distinct();
        $this->db->from('sample');
        $this->db->join('item', 'item.item_id = sample.item_id');
        $this->db->join('qualification', 'item.qualification_id = qualification.qualification_id');
        $this->db->where('faculty_id', $faculty_id);
	$this->db->where('sy_id', $syid);
	return $this->db->get()->result();
    }
    
    function getrecord($faculty_id, $syid){
        $this->db->from('sample');
        $this->db->join('item', 'item.item_id = sample.item_id');
        $this->db->where('faculty_id', $faculty_id);
        $this->db->where('sy_id', $syid);
        return $this->db->get()->result();
    }
    
    function countres(){
    $user_username = $this->session->userdata('username');
    $query = $this->db->query("SELECT COUNT(faculty_id) AS counta FROM faculty WHERE program_id in(SELECT program_id FROM program WHERE user_username = '$user_username') AND status=1 AND record_status=0");
    return $query->result();
    }
    
    function searchrecord(){
        $SY = $this->input->post('SY')+1;
        $program = $this->input->post('program');
        $keywords = $this->input->post('keywords');
        
        $this->load->model('faculty/faculty');
        $ans = $this->faculty->searchfaculty();
        
        $append; 
        if($program==0){ //get all records
            //$this->db->where('report.SY_id', $SY);
            
              if($keywords==NULL){
                //$this->db->where('record.SY_id', $SY);
                $append = " where record.SY_id = '$SY'";
              }
              
              else{
                     if($ans!=NULL){
                       //$this->db->where('record.faculty_id', $ans[0]['faculty_id']);
                       //$this->db->where('record.SY_id', $SY);
                       $append = " where record.faculty_id in(select faculty_id from faculty
                            where faculty_lname = '$keywords' or faculty_fname = '$keywords') and record.SY_id = '$SY'";
                     }
                     else{
                        //$this->db->where('record.faculty_id', 0);
                        $append = " where record.faculty_id = 0";
                     }
              }
        }
        
        else{ //search for a specific record
              
            if($keywords==NULL){ //search all records for a specific program
              //$this->db->where('faculty.program_id', $program);
              //$this->db->where('record.SY_id', $SY);
              $append = " where faculty.program_id = '$program' and record.SY_id = '$SY'";
            }
            
            else{ //search record of a specific person
              
                     if($ans!=NULL){
                     /*$this->db->where('record.faculty_id', $ans[0]['faculty_id']);
                     $this->db->where('faculty.program_id', $program);
                     $this->db->where('record.SY_id', $SY);*/
                     
                     $append = " where record.faculty_id in(select faculty_id from faculty
                        where faculty_lname = '$keywords' or faculty_fname = '$keywords')
                        and record.SY_id = '$SY' and faculty.program_id = '$program'";
                     }
                     else{
                     //$this->db->where('report.faculty_id', 0);
                     $append = " where record.faculty_id = 0";
                     }
            }
            
        }
        
       
        $query = $this->db->query("select distinct(record.faculty_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_id, program.program_name, faculty.status
                from record

                inner join faculty on record.faculty_id = faculty.faculty_id
                inner join program on program.program_id = faculty.program_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result_array();
       
    }
    
    function getassignedrecord(){
        $user_username = $this->session->userdata('username');
         $this->load->model('schoolyear/schoolyear');
        $sy_id = $this->schoolyear->getschoolyear();
        
        $SY;
        foreach($sy_id as $row){
            $SY = $row->SY_id;
        }
        
        $query = $this->db->query("select distinct(faculty.faculty_id), faculty.faculty_lname, faculty.faculty_mname,
                faculty.faculty_fname, faculty.status, program.program_name
                from record inner join faculty on record.faculty_id = faculty.faculty_id
                inner join program on program.program_id = faculty.program_id
                where program.program_id in(select program_id from program where user_username = '$user_username') AND record.SY_id = '$SY'");
        return $query->result_array();
    }
    
    function getthisrecord(){
        $user_username = $this->session->userdata('username');
         $this->load->model('schoolyear/schoolyear');
         $sy_id = $this->schoolyear->getschoolyear();
         $keywords = $this->input->post('keywords');
        
        $SY;
        foreach($sy_id as $row){
            $SY = $row->SY_id;
        }
        
        $query = $this->db->query("select distinct(faculty.faculty_id), faculty.faculty_lname, faculty.faculty_mname,
                faculty.faculty_fname, faculty.status, program.program_name
                from record inner join faculty on record.faculty_id = faculty.faculty_id
                inner join program on program.program_id = faculty.program_id
                where program.program_id in(select program_id from program where user_username = '$user_username') AND record.SY_id = '$SY' AND faculty.faculty_lname = '$keywords'");
        return $query->result_array();  
    }
    
    function getmultiplerecord(){
        $SY = $this->input->post('SY')+1;
        $program = $this->input->post('program');
        $keywords = $this->input->post('keywords');
        
        $user_username = $this->session->userdata('username');
        $assigned_reports = $this->programs->selectprogram();
        
        $this->load->model('faculty/faculty');
        $ans = $this->faculty->searchfaculty();
        
        $append;
        if($program==0){ //get all records
            //$this->db->where('report.SY_id', $SY);
            
              if($keywords==NULL){
                //$this->db->where('record.SY_id', $SY);
                 $append = " where record.SY_id = '$SY' and faculty.program_id in(select program_id from program where user_username = '$user_username')";
              }
              
              else{
                     if($ans!=NULL){
                       //$this->db->where('record.faculty_id', $ans[0]['faculty_id']);
                       //$this->db->where('record.SY_id', $SY);
                       $append = " where record.faculty_id in(select faculty_id from faculty
                            where (faculty_lname = '$keywords' or faculty_fname = '$keywords') and program_id in(select program_id from program where user_username = '$user_username')) and record.SY_id = '$SY'";
                     }
                     else{
                        //$this->db->where('record.faculty_id', 0);
                        $append = " where record.faculty_id = 0";
                     }
              }
        }
        
        else{ //search for a specific record
            
             $count = 1;
              $assigned;
       
              foreach($assigned_reports as $row){
              if($count==$this->input->post('program')){
              $assigned = $row->program_id;
              break;
              }
              $count++;
              }
              
            if($keywords==NULL){ //search all records for a specific program
              //$this->db->where('faculty.program_id', $assigned);
              //$this->db->where('record.SY_id', $SY);
               $append = " where faculty.program_id = '$assigned' and record.SY_id = '$SY'";
            }
            
            else{ //search record of a specific person
              
                     if($ans!=NULL){
                     /*$this->db->where('record.faculty_id', $ans[0]['faculty_id']);
                     $this->db->where('faculty.program_id', $assigned);
                     $this->db->where('record.SY_id', $SY);*/
                     $append = " where record.faculty_id in(select faculty_id from faculty
                        where faculty_lname = '$keywords' or faculty_fname = '$keywords')
                        and record.SY_id = '$SY' and faculty.program_id = '$assigned'";
                     }
                     else{
                     //$this->db->where('report.faculty_id', 0);
                      $append = " where record.faculty_id = 0";
                     }
            }
            
        }
        
         
        $query = $this->db->query("select distinct(record.faculty_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_id, program.program_name, faculty.status
                from record

                inner join faculty on record.faculty_id = faculty.faculty_id
                inner join program on program.program_id = faculty.program_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result_array();
    }
}

?>