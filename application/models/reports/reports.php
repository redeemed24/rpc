 <?php
 
 class Reports extends CI_Model{
    
 function insertreport(){
        $this->load->model('checklist/checklist');
        $record = $this->checklist->readrecord($this->input->post('faculty_id'), $this->input->post('sy_id'));
        
        $totalpoints = 0;
        $currsubrank_id = 0;
        $pegged_id = 0;
        $new_totalpoints = 0;
        
        foreach($record as $row){
            $totalpoints = $totalpoints + $row->points_percent;
            //echo $totalpoints.br(1);
        }
        
        $record = $this->readreport($this->input->post('faculty_id'), $this->input->post('sy_id')-1);
        
        $data = array();
        $info = array();
        
        if($record == NULL){
            $info = array('faculty_id'=>$this->input->post('faculty_id'),
                          'SY_id'=>$this->input->post('sy_id'), 'prevpoints'=>0, 'currentpoints'=>$totalpoints,
                          'total_points'=>$totalpoints, 'prevsubrank_id'=> 0);
        }
        
        else{
            foreach ($record as $row){
                $new_totalpoints = $row->total_points+$totalpoints;
                $info = array('faculty_id'=>$this->input->post('faculty_id'), 'SY_id'=>$this->input->post('sy_id'),
                          'prevpoints'=>$row->total_points, 'currentpoints'=>$totalpoints,
                          'total_points'=>$new_totalpoints, 'prevsubrank_id'=>$row->currsubrank_id);
                
                $currsubrank_id = $row->currsubrank_id;
            }
        }
       
        $subrank = $this->comparerank($new_totalpoints);
        
        $this->load->model('faculty/faculty');
        $faculty = $this->faculty->selectfaculty($this->input->post('faculty_id'));
        
        foreach($faculty as $row1){
            foreach($subrank as $row2){
                if($row1->degree_id==$row2->degree_id || $row1->degree_id == 3){
                    $currsubrank_id = $row2->subrank_id;
                    $pegged_id = 0;
                }
                else{
                    $pegged_id = $row2->subrank_id;
                }
            }
        }
        
        $user_username = $this->session->userdata('username');
        
        $data = array('faculty_id'=>$info['faculty_id'], 'SY_id'=> $info['SY_id'], 'prevpoints'=> $info['prevpoints'],
                      'currentpoints'=> $info['currentpoints'], 'total_points'=>$info['total_points'], 'prevsubrank_id'=>$info['prevsubrank_id'],
                      'pegged_id'=> $pegged_id, 'currsubrank_id'=>$currsubrank_id, 'user_username'=>$user_username);
        $this->db->insert('report', $data);
    
    }
    
    function readreport($faculty_id, $sy_id){
       $this->db->where('faculty_id', $faculty_id);
       $this->db->where('SY_id', $sy_id);
       return $this->db->get('report')->result();
    }
    
    function comparerank($new_totalpoints){
        $this->db->from('subrank');
        $this->db->join('rank', 'subrank.rank_id = rank.rank_id');
        $this->db->where('subrank.min_points <=', $new_totalpoints);
        $this->db->where('subrank.max_points >=', $new_totalpoints);
        $this->db->where('subrank.status', 1);
        return $this->db->get()->result();
    }
    
    function insertjumpreport($faculty_id){
        $this->load->model('schoolyear/schoolyear');
        $school_year = $this->schoolyear->getschoolyear();
        
       
       $ans = $this->selectminpoints($this->input->post('degree')+1);
       
       if($ans == NULL){
              if($this->input->post('degree')+1==2){
                    $ans1 = $this->selectminpoints($this->input->post('degree'));
                    if($ans1==NULL){
                       $totalpoints = 0;
                       $currsubrank_id = 0;
                       $remarks = "Recently Graduated.
                       No corresponding rank for this points";
                    }
                    
                    else{
                     foreach($ans1 as $row){
                     $totalpoints = $row->min_points;
                     $currsubrank_id = $row->subrank_id;
                     $remarks = "Recently Graduated. ";
                    }
                    }
              }
              if($this->input->post('degree')+1==1){
                       $totalpoints = 0;
                       $currsubrank_id = 0;
                       $remarks = "Recently Graduated.
                       No corresponding rank for this points"; 
              }
       }
       
       
       else{
       foreach($ans as $row){
            $totalpoints = $row->min_points;
            $currsubrank_id = $row->subrank_id;
            $remarks = "Recently Graduated. ";
       }
       }
       
       foreach($school_year as $row){
              $SY = $row->SY_id;
       }
        
        $record = $this->readreport($faculty_id, $SY-1);
        
        $data = array();
        $info = array();
        
        if($record == NULL){
            $info = array('faculty_id'=>$faculty_id,
                          'SY_id'=>$SY, 'prevpoints'=>0, 'currentpoints'=>0, //$totalpoints
                          'total_points'=>$totalpoints, 'prevsubrank_id'=>0, 'remarks'=>$remarks);
        }
        
        else{
               foreach ($record as $row){
               $info = array('faculty_id'=>$faculty_id,
                             'SY_id'=>$SY, 'currentpoints'=>0, //$totalpoints
                             'total_points'=>$totalpoints,'prevpoints'=>$row->total_points,
                             'prevsubrank_id' =>$row->currsubrank_id, 'remarks'=>$remarks);
              }       
        }
        
        $this->load->helper('date');
        $datestring = "%m/%d/%Y";
        $time = time();
        $date = mdate($datestring, $time);
        
        $user_username = $this->session->userdata('username');
        $data = array('faculty_id'=>$info['faculty_id'], 'SY_id'=> $info['SY_id'], 'prevpoints'=> $info['prevpoints'],
                      'currentpoints'=> $info['currentpoints'], 'total_points'=>$info['total_points'], 'prevsubrank_id'=>$info['prevsubrank_id'],
                      'pegged_id'=> 0, 'currsubrank_id'=>$currsubrank_id, 'user_username'=>$user_username, 'remarks'=>$info['remarks'], 'date'=>$date);
        
        $this->db->insert('report', $data);
        
    }
    
    function insertactivate($faculty_id, $degree){
        $this->load->model('schoolyear/schoolyear');
        $school_year = $this->schoolyear->getschoolyear();
        
        //$degree = $this->input->post('degree')+1;
        if($degree == 3){
              $degree = 2;
        }
        
       $ans = $this->selectminpoints($degree);
       
       if($ans == NULL){
              if($degree==2){
                    $ans1 = $this->selectminpoints(1);
                    if($ans1==NULL){
                       $totalpoints = 0;
                       $currsubrank_id = 0;
                       $remarks = "Recently Graduated.
                       No corresponding rank for this points";
                    }
                    
                    else{
                     foreach($ans1 as $row){
                     $totalpoints = $row->min_points;
                     $currsubrank_id = $row->subrank_id;
                     $remarks = "Recently Graduated. ";
                    }
                    }
              }
              if($degree==1){
                       $totalpoints = 0;
                       $currsubrank_id = 0;
                       $remarks = "Recently Graduated.
                       No corresponding rank for this points"; 
              }
       }
       
       
       else{
       foreach($ans as $row){
            $totalpoints = $row->min_points;
            $currsubrank_id = $row->subrank_id;
            $remarks = "Recently Graduated. ";
       }
       }
       
       foreach($school_year as $row){
              $SY = $row->SY_id;
       }
        
        $record = $this->readreport($faculty_id, $SY-1);
        
        $data = array();
        $info = array();
        
    
        if($record == NULL){
            $info = array('faculty_id'=>$faculty_id,
                          'SY_id'=>$SY, 'prevpoints'=>0, 'currentpoints'=>0, //$totalpoints
                          'total_points'=>$totalpoints, 'prevsubrank_id'=> 0, 'remarks'=>'Recently Graduated');
        }
        
        else{
               foreach ($record as $row){
               $info = array('faculty_id'=>$faculty_id,
                             'SY_id'=>$SY, 'currentpoints'=>0, //$totalpoints
                             'total_points'=>$totalpoints,'prevpoints'=>$row->total_points,
                             'prevsubrank_id' =>$row->currsubrank_id, 'remarks'=>'Recently Graduated');
              }       
        }
        $this->load->helper('date');
        
        $user_username = $this->session->userdata('username');
        $datestring = "%m/%d/%Y";
        $time = time();
        $date = mdate($datestring, $time);
        
        $data = array('faculty_id'=>$info['faculty_id'], 'SY_id'=> $info['SY_id'], 'prevpoints'=> $info['prevpoints'],
                      'currentpoints'=> $info['currentpoints'], 'total_points'=>$info['total_points'], 'prevsubrank_id'=>$info['prevsubrank_id'],
                      'pegged_id'=> 0, 'currsubrank_id'=>$currsubrank_id, 'user_username'=>$user_username, 'date'=> $date);
        
        $this->db->insert('report', $data);
    }
    
    function selectminpoints($degree_id){
    $query = $this->db->query("select subrank.subrank_id, subrank.min_points from subrank where subrank.min_points in(select min(subrank.min_points) as min_points from subrank inner join rank on rank.rank_id = subrank.rank_id
                            where rank.status = 1 and rank.degree_id = '$degree_id' and subrank.status = 1)");
    return $query->result();
    }
    
    function updatereport(){
        
        $this->load->model('checklist/checklist');
        $record = $this->checklist->readrecord($this->input->post('faculty_id'), $this->input->post('sy_id'));
        
        $totalpoints = 0;
        $currsubrank_id = 0;
        $pegged_id = 0;
        $new_totalpoints = 0;
        
        foreach($record as $row){
            $totalpoints = $totalpoints + $row->points_percent;
        }
        
        $record = $this->readreport($this->input->post('faculty_id'), $this->input->post('sy_id')-1);
        
        $data = array();
        $info = array();
        
        if($record == NULL){
            $info = array('faculty_id'=>$this->input->post('faculty_id'),
                          'SY_id'=>$this->input->post('sy_id'), 'prevpoints'=>0, 'currentpoints'=>$totalpoints,
                          'total_points'=>$totalpoints, 'prevsubrank_id'=> 0);
        }
        
        else{
            foreach ($record as $row){
                $new_totalpoints = $row->total_points+$totalpoints;
                $info = array('faculty_id'=>$this->input->post('faculty_id'), 'SY_id'=>$this->input->post('sy_id'),
                          'prevpoints'=>$row->total_points, 'currentpoints'=>$totalpoints,
                          'total_points'=>$new_totalpoints, 'prevsubrank_id'=>$row->currsubrank_id);
                
                $currsubrank_id = $row->currsubrank_id;
            }
        }
       
        $subrank = $this->comparerank($new_totalpoints);
        
        $this->load->model('faculty/faculty');
        $faculty = $this->faculty->selectfaculty($this->input->post('faculty_id'));
        
        foreach($faculty as $row1){
            foreach($subrank as $row2){
                if($row1->degree_id==$row2->degree_id || $row1->degree_id == 3){
                    $currsubrank_id = $row2->subrank_id;
                    $pegged_id = 0;
                }
                else{
                    $pegged_id = $row2->subrank_id;
                }
            }
        }
        
        if($this->session->userdata('userlevel_id')==2){
              $update = $this->session->userdata('username');
        }
        else{
              $update = NULL;
        }
        
        $data = array('faculty_id'=>$info['faculty_id'], 'SY_id'=> $info['SY_id'], 'prevpoints'=> $info['prevpoints'],
                      'currentpoints'=> $info['currentpoints'], 'total_points'=>$info['total_points'], 'prevsubrank_id'=>$info['prevsubrank_id'],
                      'pegged_id'=> $pegged_id, 'currsubrank_id'=>$currsubrank_id, 'updated'=>$update);
        
        $this->db->where('faculty_id', $info['faculty_id']);
        $this->db->where('SY_id', $info['SY_id']);
        $this->db->update('report', $data);
       
    }
    
    function getreport($faculty_id, $sy_id){
       $this->db->where('faculty_id', $faculty_id);
       $this->db->where('SY_id', $sy_id);
       return $this->db->get('report')->result();
       }
       
     function loadallreport(){
        $SY = $this->input->post('SY')+1;
        $program = $this->input->post('program');
        $keywords = $this->input->post('keywords');
        
        $this->load->model('faculty/faculty');
        $ans = $this->faculty->searchfaculty();
        
        $append;
        if($program==0){ //get all records
            //$this->db->where('report.SY_id', $SY);
            
              if($keywords==NULL){
              $append = " where report.SY_id = '$SY'";
                //$this->db->where('report.SY_id', $SY);     
              }
              
              else{
                     if($ans!=NULL){
                       //$this->db->where('report.faculty_id', $ans[0]['faculty_id']);
                       //$this->db->where('report.SY_id', $SY);
                       $append = " where report.faculty_id in(select faculty_id from faculty where faculty_lname = '$keywords' or faculty_fname = '$keywords') and report.SY_id = '$SY'";
                     }
                     else{
                        //$this->db->where('report.faculty_id', 0);
                        $append = " where report.faculty_id = 0";
                     }
              }
        }
        
        else{ //search for a specific record
              
            if($keywords==NULL){ //search all records for a specific program
              //$this->db->where('program.program_id', $program);
              //$this->db->where('report.SY_id', $SY);
              $append = " where report.SY_id = '$SY' and program.program_id = '$program'";
            }
            
            else{ //search record of a specific person
              
                     if($ans!=NULL){
                     //$this->db->where('report.faculty_id', $ans[0]['faculty_id']);
                     //$this->db->where('program.program_id', $program);
                     //$this->db->where('report.SY_id', $SY);
                     
                     $append = " where report.faculty_id in(select faculty_id from faculty where faculty_lname = '$keywords' or faculty_fname = '$keywords') and report.SY_id = '$SY'
                                   and program.program_id = '$program' ";
                     }
                     else{
                     //$this->db->where('report.faculty_id', 0);
                     $append = " where report.faculty_id = 0";
                     }
            }
            
        }
        
        
        $query = $this->db->query("select distinct(report.report_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_name,
                     report.currentpoints,report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous,
                     report.total_points, currrank.rank_name as current_rank, currsubrank.subrank_num as current,
                     pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg,
                     faculty.faculty_id, report.SY_id, report.remarks, program.program_id, program.program_name


                     from report

                     inner join faculty on report.faculty_id = faculty.faculty_id
                     inner join program on faculty.program_id = program.program_id

                     inner join subrank as prevsubrank on prevsubrank.subrank_id = report.prevsubrank_id
                     inner join subrank as currsubrank on currsubrank.subrank_id = report.currsubrank_id
                     inner join subrank as pegsubrank on pegsubrank.subrank_id = report.pegged_id


                     inner join rank as prevrank on prevsubrank.rank_id = prevrank.rank_id
                     inner join rank as currrank on currsubrank.rank_id = currrank.rank_id
                     inner join rank as pegrank on pegsubrank.rank_id = pegrank.rank_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result_array();
       
     }
     
     
      function loadprintallreport($val, $program_id, $sy_id){

       $this->db->select('report.remarks, report.report_id, program.program_name, faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, report.currentpoints, report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous, report.total_points,
       currrank.rank_name as current_rank, currsubrank.subrank_num as current, pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg, faculty.faculty_id, report.SY_id');

       $this->db->from('report');
       $this->db->join('faculty', 'report.faculty_id = faculty.faculty_id');
       $this->db->join('program', 'faculty.program_id = program.program_id');
       $this->db->join('subrank as prevsubrank', 'prevsubrank.subrank_id = report.prevsubrank_id');
       $this->db->join('subrank as currsubrank', 'currsubrank.subrank_id = report.currsubrank_id');
       $this->db->join('subrank as pegsubrank', 'pegsubrank.subrank_id = report.pegged_id');
       $this->db->join('rank as prevrank', 'prevsubrank.rank_id = prevrank.rank_id');
       $this->db->join('rank as currrank', 'currsubrank.rank_id = currrank.rank_id');
       $this->db->join('rank as pegrank', 'pegsubrank.rank_id = pegrank.rank_id');
       
       $append; 
       if($val==1){
       //$this->db->where('program.program_id', $program_id);
       $append = " where program.program_id = '$program_id' and report.SY_id = '$sy_id'";
       }
       
       else{
       $append = " where report.SY_id = '$sy_id'";
       }
       /*$this->db->where('report.SY_id', $sy_id);
       $this->db->order_by('faculty.faculty_lname', 'asc');
        
        $query = $this->db->get();
        return $query->result();*/
       
        $query = $this->db->query("select distinct(report.report_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_name,
                     report.currentpoints,report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous,
                     report.total_points, currrank.rank_name as current_rank, currsubrank.subrank_num as current,
                     pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg,
                     faculty.faculty_id, report.SY_id, report.remarks, program.program_id, program.program_name


                     from report

                     inner join faculty on report.faculty_id = faculty.faculty_id
                     inner join program on faculty.program_id = program.program_id

                     inner join subrank as prevsubrank on prevsubrank.subrank_id = report.prevsubrank_id
                     inner join subrank as currsubrank on currsubrank.subrank_id = report.currsubrank_id
                     inner join subrank as pegsubrank on pegsubrank.subrank_id = report.pegged_id


                     inner join rank as prevrank on prevsubrank.rank_id = prevrank.rank_id
                     inner join rank as currrank on currsubrank.rank_id = currrank.rank_id
                     inner join rank as pegrank on pegsubrank.rank_id = pegrank.rank_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result();   
     }
     
     
     function loadprintassignedreport($val, $program_id, $sy_id){
  
       $user_username = $this->session->userdata('username');
       $append;
       
       if($val==1){
       $append = " where program.program_id = '$program_id' and report.SY_id = '$sy_id'";
       }
       
       else{
       $append = " where report.SY_id = '$sy_id' and faculty.program_id in(select program_id from program where user_username = '$user_username')";
       }
            
        $query = $this->db->query("select distinct(report.report_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_name,
                     report.currentpoints,report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous,
                     report.total_points, currrank.rank_name as current_rank, currsubrank.subrank_num as current,
                     pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg,
                     faculty.faculty_id, report.SY_id, report.remarks, program.program_id, program.program_name


                     from report

                     inner join faculty on report.faculty_id = faculty.faculty_id
                     inner join program on faculty.program_id = program.program_id

                     inner join subrank as prevsubrank on prevsubrank.subrank_id = report.prevsubrank_id
                     inner join subrank as currsubrank on currsubrank.subrank_id = report.currsubrank_id
                     inner join subrank as pegsubrank on pegsubrank.subrank_id = report.pegged_id


                     inner join rank as prevrank on prevsubrank.rank_id = prevrank.rank_id
                     inner join rank as currrank on currsubrank.rank_id = currrank.rank_id
                     inner join rank as pegrank on pegsubrank.rank_id = pegrank.rank_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result();   
       
     }
     
     
     
     function individualrep($faculty_id, $sy_id){
       $this->db->select('report.date, users.user_fname, users.user_lname, report.remarks, report.report_id, program.program_name, faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, report.currentpoints, report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous, report.total_points,
       currrank.rank_name as current_rank, currsubrank.subrank_num as current, pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg, faculty.faculty_id, report.SY_id');

       $this->db->from('report');
       $this->db->join('faculty', 'report.faculty_id = faculty.faculty_id');
       $this->db->join('users', 'report.user_username = users.user_username');
       $this->db->join('program', 'faculty.program_id = program.program_id');
       $this->db->join('subrank as prevsubrank', 'prevsubrank.subrank_id = report.prevsubrank_id');
       $this->db->join('subrank as currsubrank', 'currsubrank.subrank_id = report.currsubrank_id');
       $this->db->join('subrank as pegsubrank', 'pegsubrank.subrank_id = report.pegged_id');
       $this->db->join('rank as prevrank', 'prevsubrank.rank_id = prevrank.rank_id');
       $this->db->join('rank as currrank', 'currsubrank.rank_id = currrank.rank_id');
       $this->db->join('rank as pegrank', 'pegsubrank.rank_id = pegrank.rank_id');
       $this->db->where('report.faculty_id', $faculty_id);
       $this->db->where('SY_id', $sy_id);
       
        $query = $this->db->get();
        return $query->result_array();
        
     }
     
     function reportforchair(){
       
       $this->load->model('schoolyear/schoolyear');
       
       $result = $this->schoolyear->getschoolyear();
       
       $SY_id;
       foreach($result as $row){
              $SY_id[0] = array('id'=>$row->SY_id);
       }
       
       $user_username = $this->session->userdata('username');
       $var = $SY_id[0]['id'];
       
       $query = $this->db->query("select distinct(report.report_id), report.remarks, program.program_id, report.SY_id, report.faculty_id, program.program_name, faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, report.currentpoints, report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous, report.total_points,
                     currrank.rank_name as current_rank, currsubrank.subrank_num as current, pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg
                     from report

                            inner join faculty on report.faculty_id = faculty.faculty_id
                            inner join program on faculty.program_id = program.program_id

                            inner join (subrank as prevsubrank, subrank as currsubrank, subrank as pegsubrank)
                            on (prevsubrank.subrank_id = report.prevsubrank_id and currsubrank.subrank_id = report.currsubrank_id and pegsubrank.subrank_id = report.pegged_id)

                            inner join (rank as prevrank, rank as currrank, rank as pegrank)
                            on (prevsubrank.rank_id = prevrank.rank_id and currsubrank.rank_id = currrank.rank_id and pegsubrank.rank_id = pegrank.rank_id)
                            
                            where report.faculty_id in

                            (select faculty.faculty_id from faculty where faculty.program_id in
                            (select program.program_id from program where program.user_username = '$user_username'))

                            and SY_id = '$var' ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
       
       return $query->result_array();
     }
     
     function loadreportassign(){
       $this->load->model('schoolyear/schoolyear');
       
       $keywords = $this->input->post('keywords');
       $result = $this->schoolyear->getschoolyear();
       
       $SY_id;
       foreach($result as $row){
              $SY_id[0] = array('id'=>$row->SY_id);
       }
       
       $user_username = $this->session->userdata('username');
       $var = $SY_id[0]['id'];
       
       $query = $this->db->query("select distinct(report.report_id), report.remarks, program.program_id, report.report_id, report.SY_id, report.faculty_id, program.program_name, faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, report.currentpoints, report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous, report.total_points,
                     currrank.rank_name as current_rank, currsubrank.subrank_num as current, pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg
                     from report

                            inner join faculty on report.faculty_id = faculty.faculty_id
                            inner join program on faculty.program_id = program.program_id

                            inner join (subrank as prevsubrank, subrank as currsubrank, subrank as pegsubrank)
                            on (prevsubrank.subrank_id = report.prevsubrank_id and currsubrank.subrank_id = report.currsubrank_id and pegsubrank.subrank_id = report.pegged_id)

                            inner join (rank as prevrank, rank as currrank, rank as pegrank)
                            on (prevsubrank.rank_id = prevrank.rank_id and currsubrank.rank_id = currrank.rank_id and pegsubrank.rank_id = pegrank.rank_id)
                            
                            where report.faculty_id in

                            (select faculty.faculty_id from faculty where (faculty.faculty_lname = '$keywords' or faculty.faculty_fname = '$keywords')and faculty.program_id in
                            (select program.program_id from program where program.user_username = '$user_username'))

                            and SY_id = $var");
       
       return $query->result_array();
     }
     
     function previousrank($id, $sy_id){
       
       $this->db->select ('rank.rank_name, subrank_num');
       $this->db->from ('report');
       $this->db->join ('subrank', 'report.prevsubrank_id = subrank_id');
       $this->db->join ('rank','subrank.rank_id = rank.rank_id');
       $this->db->where ('report.faculty_id', $id);
       $this->db->where ('report.SY_id', $sy_id);
       
       return $this->db->get()->result();
     }
     
      function loadallreportforchair(){
            
        $this->load->model('schoolyear/schoolyear');
        $sy_id = $this->schoolyear->getschoolyear();
        
        $SY;
        foreach($sy_id as $row){
            $SY = $row->SY_id;
        }
        
        $program = $this->input->post('program');
        $keywords = $this->input->post('keywords');
        
        $this->load->model('faculty/faculty');
        $ans = $this->faculty->searchfaculty();
              
        $append;
        if($program==0){ //get all records
            //$this->db->where('report.SY_id', $SY);
            
              if($keywords==NULL){
              $append = " where report.SY_id = '$SY'";
                //$this->db->where('report.SY_id', $SY);     
              }
              
              else{
                     if($ans!=NULL){
                       //$this->db->where('report.faculty_id', $ans[0]['faculty_id']);
                       //$this->db->where('report.SY_id', $SY);
                       $append = " where report.faculty_id in(select faculty_id from faculty where faculty_lname = '$keywords' or faculty_fname = '$keywords') and report.SY_id = '$SY'";
                     }
                     else{
                        //$this->db->where('report.faculty_id', 0);
                        $append = " where report.faculty_id = 0";
                     }
              }
        }
        
        else{ //search for a specific record
              
            if($keywords==NULL){ //search all records for a specific program
              //$this->db->where('program.program_id', $program);
              //$this->db->where('report.SY_id', $SY);
              $append = " where report.SY_id = '$SY' and program.program_id = '$program'";
            }
            
            else{ //search record of a specific person
              
                     if($ans!=NULL){
                     //$this->db->where('report.faculty_id', $ans[0]['faculty_id']);
                     //$this->db->where('program.program_id', $program);
                     //$this->db->where('report.SY_id', $SY);
                     
                     $append = " where report.faculty_id in(select faculty_id from faculty where faculty_lname = '$keywords' or faculty_fname = '$keywords') and report.SY_id = '$SY'
                                   and program.program_id = '$program' ";
                     }
                     else{
                     //$this->db->where('report.faculty_id', 0);
                     $append = " where report.faculty_id = 0";
                     }
            }
            
        }
        
        
        $query = $this->db->query("select distinct(report.report_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_name,
                     report.currentpoints,report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous,
                     report.total_points, currrank.rank_name as current_rank, currsubrank.subrank_num as current,
                     pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg,
                     faculty.faculty_id, report.SY_id, report.remarks, program.program_id, program.program_name


                     from report

                     inner join faculty on report.faculty_id = faculty.faculty_id
                     inner join program on faculty.program_id = program.program_id

                     inner join subrank as prevsubrank on prevsubrank.subrank_id = report.prevsubrank_id
                     inner join subrank as currsubrank on currsubrank.subrank_id = report.currsubrank_id
                     inner join subrank as pegsubrank on pegsubrank.subrank_id = report.pegged_id


                     inner join rank as prevrank on prevsubrank.rank_id = prevrank.rank_id
                     inner join rank as currrank on currsubrank.rank_id = currrank.rank_id
                     inner join rank as pegrank on pegsubrank.rank_id = pegrank.rank_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        
        return $query->result_array();
       
     }
     
     function save_remarks($report_id){
       $this->db->set('remarks', $this->input->post('remarks'));
       $this->db->where('report_id', $report_id);
       $this->db->update('report');
     }
     
     function loadmultiplereports(){
        $this->load->model('programs/programs');
        $assigned_reports = $this->programs->selectprogram();
        $this->load->model('schoolyear/schoolyear');
        $sy_id = $this->schoolyear->getschoolyear();
        
        $SY;
        foreach($sy_id as $row){
            $SY = $row->SY_id;
        }
        
        $program = $this->input->post('program');
        $keywords = $this->input->post('keywords');
        
        $this->load->model('faculty/faculty');
        $ans = $this->faculty->searchfaculty();
         
         $user_username = $this->session->userdata('username');
       $append;     
      
        if($program==0){ //get all records
            //$this->db->where('report.SY_id', $SY);
             if($keywords==NULL){
                //$this->db->where('report.SY_id', $SY);
                 $append = " where report.SY_id = '$SY' and faculty.program_id in(select program_id from program where user_username = '$user_username')";
              }
              
              else{
                     if($ans!=NULL){
                            //$this->db->where('report.faculty_id', $ans[0]['faculty_id']);
                            //$this->db->where('report.SY_id', $SY);
                            $append = " where report.faculty_id in(select faculty_id from faculty where (faculty_lname = '$keywords' or faculty_fname = '$keywords') and faculty.program_id in(select program.program_id from program where user_username = '$user_username'))and report.SY_id = '$SY'";
                     }
                     else{
                        //$this->db->where('report.faculty_id', 0);
                         $append = " where report.faculty_id = 0";
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
              /*$this->db->where('program.program_id', $assigned);
              $this->db->where('report.SY_id', $SY);*/
              $append = " where report.SY_id = '$SY' and program.program_id = '$assigned'";
            }
            
            else{ //search record of a specific person
                      if($ans!=NULL){
                      /*$this->db->where('report.faculty_id', $ans[0]['faculty_id']);
                      $this->db->where('program.program_id', $assigned);
                      $this->db->where('report.SY_id', $SY);*/
                      $append = " where report.faculty_id in(select faculty_id from faculty where faculty_lname = '$keywords' or faculty_fname = '$keywords') and report.SY_id = '$SY'
                                   and program.program_id = '$assigned' ";
                      }
                      
                     else{
                     $append = " where program.program_id = 0";     
                      }         
            }
            
        }
        
        $query = $this->db->query("select distinct(report.report_id), faculty.faculty_lname, faculty.faculty_fname, faculty.faculty_mname, program.program_name,
                     report.currentpoints,report.prevpoints, prevrank.rank_name as previous_rank, prevsubrank.subrank_num as previous,
                     report.total_points, currrank.rank_name as current_rank, currsubrank.subrank_num as current,
                     pegrank.rank_name as pegged, pegsubrank.subrank_num as pegg,
                     faculty.faculty_id, report.SY_id, report.remarks, program.program_id, program.program_name


                     from report

                     inner join faculty on report.faculty_id = faculty.faculty_id
                     inner join program on faculty.program_id = program.program_id

                     inner join subrank as prevsubrank on prevsubrank.subrank_id = report.prevsubrank_id
                     inner join subrank as currsubrank on currsubrank.subrank_id = report.currsubrank_id
                     inner join subrank as pegsubrank on pegsubrank.subrank_id = report.pegged_id


                     inner join rank as prevrank on prevsubrank.rank_id = prevrank.rank_id
                     inner join rank as currrank on currsubrank.rank_id = currrank.rank_id
                     inner join rank as pegrank on pegsubrank.rank_id = pegrank.rank_id $append ORDER BY faculty.faculty_lname, faculty.faculty_fname ASC");
        return $query->result_array();     
     }
    
    
    function updatejumpreport($fac_id, $sy_id, $eq){
       $record = $this->readreport($fac_id, $sy_id);
       
       $ans = $this->selectminpoints($eq);
       
       $totalpoints; $currsubrank_id;
       
        if($ans == NULL){
              if($eq==2){
                    $ans1 = $this->selectminpoints(1);
                    if($ans1==NULL){
                       $totalpoints = 0;
                       $currsubrank_id = 0;
                       $remarks = "Recently Graduated.
                       No corresponding rank for this points";
                    }
                    
                    else{
                     foreach($ans1 as $row){
                     $totalpoints = $row->min_points;
                     $currsubrank_id = $row->subrank_id;
                     $remarks = "Recently Graduated. ";
                    }
                    }
              }
              if($eq==1){
                       $totalpoints = 0;
                       $currsubrank_id = 0;
                       $remarks = "Recently Graduated.
                       No corresponding rank for this points"; 
              }
       }
       
       
       else{
       foreach($ans as $row){
            $totalpoints = $row->min_points;
            $currsubrank_id = $row->subrank_id;
            $remarks = "Recently Graduated. ";
       }
       }
       
       $user_username = $this->session->userdata('username');
       
       foreach($record as $row){
            $this->db->set('total_points', $totalpoints);
            $this->db->set('currentpoints', 0);
            $this->db->set('currsubrank_id', $currsubrank_id);
            $this->db->set('pegged_id', 0);
            $this->db->set('remarks', 'Recently Graduated');
            $this->db->set('user_username', $user_username);
            $this->db->where('report_id', $row->report_id);
            $this->db->update('report');
            echo $row->report_id;
       }
    }
    
    function getupdate($id, $sy_id){
       $query = $this->db->query("select users.user_fname, users.user_lname from report inner join users on users.user_username = report.updated where report.SY_id = '$sy_id' and faculty_id = '$id'");
       return $query->result();
    }
 }
 
 ?>