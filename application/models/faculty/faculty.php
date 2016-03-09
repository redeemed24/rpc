<?php

class Faculty extends CI_Model{
    
    //Add faculty information to database
    function insertfaculty(){
        if($this->input->post('status')==1){
            $status=0;
        }
        else{
            $status=1;
        }
    $info= array('faculty_fname' => $this->input->post('faculty_fname'),
                 'faculty_mname' => $this->input->post('faculty_mname'),
                 'faculty_lname' => $this->input->post('faculty_lname'),
                 'faculty_gender'=> $this->input->post('faculty_gender'),
                 'program_id' => $this->input->post('program')+1,
                 'degree_id' => $this->input->post('degree')+1,
                 'status' => $status);
    
    $this->db->insert('faculty', $info);
    }
    
    //Check existing faculty record
    function checkfaculty($lname, $mname, $fname){
    $info= array('faculty_fname' => $fname, 'faculty_mname' => $mname, 'faculty_lname' =>$lname);
    $this->db->where($info);
    return $this->db->get('faculty')->result();
    }
    
    //List of faculties
    function getallfaculties(){
        $this->db->select('faculty.faculty_id, faculty.degree_id, faculty.faculty_fname, faculty.faculty_mname, faculty.faculty_lname, program.program_name, faculty.status');    
        $this->db->from('faculty');
        $this->db->join('program', 'faculty.program_id = program.program_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //Get faculty info
    function selectfaculty($faculty_id){
        $this->db->where('faculty_id', $faculty_id);
        return $this->db->get('faculty')->result();
    }
    
    function sfaculty($faculty_id){
        $this->db->where('faculty_id', $faculty_id);
        return $this->db->get('faculty')->result();
    }
    
    //Update a faculty
    function setfaculty($faculty_id){
        $data = array('faculty_fname' => $this->input->post('faculty_fname'),
                      'faculty_mname' => $this->input->post('faculty_mname'),
                      'faculty_lname' => $this->input->post('faculty_lname'),
                      'faculty_gender' => $this->input->post('faculty_gender'),
                      'program_id' => $this->input->post('program')+1,
                      'degree_id' => $this->input->post('degree')+1,
                      'status' => $this->input->post('status')
                      );
    
        $this->db->where('faculty_id', $faculty_id);
        $this->db->update('faculty', $data);
    }
    
    //update faculty record status
    function setstatus($status, $faculty_id){
        $this->db->set('status', $status);
        $this->db->where('faculty_id', $faculty_id);
        $this->db->update('faculty');
        
        if($status==1){
            $info = $this->selectfaculty($faculty_id);
            
            $this->load->model('schoolyear/schoolyear');
              $school_year = $this->schoolyear->getschoolyear();
              
                foreach($school_year as $row){
                $SY = $row->SY_id;
                }
            
            $eq;
            foreach($info as $row){
                $eq = $row->degree_id;
            }
            
             if($eq==3){
                    $eq = 2;
                }
                
            $this->load->model('reports/reports');
            
            if($this->reports->readreport($faculty_id, $SY)==NULL){ 
            $this->reports->insertactivate($faculty_id, $eq);
            }
            
            else{
                $this->reports->updatejumpreport($faculty_id, $SY, $eq);
            }
        }
    }
    
    //function search faculty
    function searchfaculty(){
    $keywords = $this->input->post('keywords');
        
        $this->db->select('faculty.status, faculty.degree_id, faculty.faculty_id, faculty.faculty_fname, faculty.faculty_mname, faculty.faculty_lname, program.program_name, faculty.program_id');    
        $this->db->from('faculty');
        $this->db->join('program', 'faculty.program_id = program.program_id');
        $this->db->where('faculty.faculty_fname', $keywords);
        $this->db->or_where('faculty.faculty_mname', $keywords);
        $this->db->or_where('faculty.faculty_lname', $keywords);
        $this->db->or_where("CONCAT_WS(' ', faculty.faculty_fname, faculty.faculty_mname, faculty.faculty_lname) = '$keywords'");
        $this->db->or_where("CONCAT_WS(' ', faculty.faculty_fname, faculty.faculty_mname) = '$keywords'");
        $this->db->or_where("CONCAT_WS(' ', faculty.faculty_fname, faculty.faculty_lname) = '$keywords'");
        $this->db->or_where("CONCAT_WS(' ', faculty.faculty_mname, faculty.faculty_lname) = '$keywords'");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //set record status faculty to 1 for ranking purposes
    function setrecordstatus(){
        $this->db->set('record_status', 0);
        $this->db->update('faculty');
    }
    
    function setrecord($faculty_id){
        $this->db->set('record_status', 1);
        $this->db->where('faculty_id', $faculty_id);
        $this->db->update('faculty');
    }
    
    function getrankedfaculties(){
        $user_username = $this->session->userdata('username');
        $query = $this->db->query("SELECT * FROM faculty inner join program on program.program_id = faculty.program_id where faculty.program_id in(SELECT program.program_id FROM program where program.user_username = '$user_username')
                                    AND faculty.status = '1' AND faculty.record_status = '1'");
        return $query->result_array();
    }
    
    //get last id
    function getmaxid(){
        $this->db->select_max('faculty_id');
        return $this->db->get('faculty')->result();
    }
    
    function getallfacultiesforchair(){
        $this->load->model('schoolyear/schoolyear');
        $SY = $this->schoolyear->getschoolyear();
        
        $sy_id;
        foreach($SY as $row){
            $sy_id = $row->SY_id;
        }
        
        $query = $this->db->query("select * from faculty inner join program on program.program_id = faculty.program_id where faculty.faculty_id in(select distinct report.faculty_id from report where report.SY_id = '$sy_id')");
        return $query->result_array();
    }
    
    function findfaculty(){
        
        $program = $this->input->post('program');
        $keywords = $this->input->post('keywords');
        
        $this->db->select('faculty.status, faculty.degree_id, faculty.faculty_id, faculty.faculty_fname, faculty.faculty_mname, faculty.faculty_lname, program.program_name, faculty.program_id');    
        $this->db->from('faculty');
        $this->db->join('program', 'faculty.program_id = program.program_id');
       
        
        if($program==0){
            if($this->input->post('keywords')!=NULL){
            
            $this->db->where('faculty.faculty_fname', $keywords);
            $this->db->or_where('faculty.faculty_mname', $keywords);
            $this->db->or_where('faculty.faculty_lname', $keywords);
            $this->db->or_where("CONCAT_WS(' ', faculty.faculty_fname, faculty.faculty_mname, faculty.faculty_lname) = '$keywords'");
            $this->db->or_where("CONCAT_WS(' ', faculty.faculty_fname, faculty.faculty_mname) = '$keywords'");
            $this->db->or_where("CONCAT_WS(' ', faculty.faculty_fname, faculty.faculty_lname) = '$keywords'");
            $this->db->or_where("CONCAT_WS(' ', faculty.faculty_mname, faculty.faculty_lname) = '$keywords'");
            }
        }
        
        else{
            $this->db->where('faculty.program_id', $this->input->post('program'));
            
            if($this->input->post('keywords')!=NULL){
            $this->db->where('faculty.faculty_lname', $keywords);
            $this->db->or_where('faculty.faculty_fname', $keywords);
            //$this->db->where('faculty.program_id', $this->input->post('program'));
            }
        }
        
        $this->db->order_by('faculty.faculty_lname', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function loadfaculties(){
        $user_username = $this->session->userdata('username');
        $query = $this->db->query("select faculty.faculty_lname, faculty.faculty_mname, faculty.faculty_fname, faculty.faculty_id, program.program_name
                from faculty inner join program on program.program_id = faculty.program_id where faculty.program_id
                in(select program_id from program
                where user_username = '$user_username') and faculty.status = 1 and faculty.record_status = 0 ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result_array();
    }
}
?>