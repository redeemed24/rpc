<?php

class Update_faculty extends CI_Controller{
    function updatefaculty($faculty_id){
        if($this->session->userdata('login')==1){
        $this->load->model('faculty/faculty');
        $this->faculty->setfaculty($faculty_id);
        
        //nag change iyang degree tpos status ==1
        if($this->input->post('old_degree')+1!=$this->input->post('degree')+1 && $this->input->post('status')==$this->input->post('old_status')){ // Status is not changed
            $this->load->model('reports/reports');
            
              $this->load->model('schoolyear/schoolyear');
              $school_year = $this->schoolyear->getschoolyear();
              
                foreach($school_year as $row){
                $SY = $row->SY_id;
                }
            
            if($this->input->post('status')==1){ //status is activated
                //if($this->reports->readreport($faculty_id, $SY)==NULL && $this->input->post('degree')+1 != 3){
                if($this->reports->readreport($faculty_id, $SY)==NULL){
                    if($this->input->post('degree')+1==3){
                        $reports = $this->reports->readreport($faculty_id, $SY-1);
                        foreach($reports as $row){
                            if($row->pegged_id!=0){
                             $this->reports->insertjumpreport($faculty_id);
                             $this->faculty->setrecord($faculty_id);     
                            }
                        }
                    }
                    else{
                    $this->reports->insertjumpreport($faculty_id);
                    $this->faculty->setrecord($faculty_id); 
                    }
                }
            
                else if($this->reports->readreport($faculty_id, $SY)!=NULL && $this->input->post('degree')+1 != 3){
                $this->reports->updatejumpreport($faculty_id, $SY, $this->input->post('degree')+1 && $this->input->post('degree')+1 != 3);
                $this->faculty->setrecord($faculty_id);
                }
            }
            
            //$this->faculty->setrecord($faculty_id);
        }
        
        //wala nag change ang degree tpos ang status kay ==1
        else if($this->input->post('status')!=$this->input->post('old_status') && $this->input->post('status')==1){ //degree is changed
            $this->faculty->setstatus(1,$faculty_id);
            $this->faculty->setrecord($faculty_id);
        }
        
        redirect(base_url().'Rpc/loadallfaculties','refresh');
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function updatestatus($status, $faculty_id, $eq){
        if($this->session->userdata('login')==1){
        $this->load->model('faculty/faculty');
        $this->faculty->setstatus($status, $faculty_id, $eq);
        $this->faculty->setrecord($faculty_id);
        redirect(base_url().'Rpc/loadallfaculties','refresh');        
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
}
?>