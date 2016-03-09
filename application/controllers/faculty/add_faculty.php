<?php

class Add_faculty extends CI_Controller{
    function addfaculty(){
        if($this->session->userdata('login')==1){
        $this->load->model('faculty/faculty');
        $this->load->model('reports/reports');
        
	$ans = $this->faculty->checkfaculty($this->input->post('faculty_lname'), $this->input->post('faculty_mname'), $this->input->post('faculty_fname'));
        
	if($ans==NULL){
	$this->faculty->insertfaculty();
            
                if($this->input->post('status')==0){
                    
                $id = $this->faculty->getmaxid();
                $info;
                    foreach($id as $row){
                    $info = $row->faculty_id;
                    }
                
                $this->reports->insertactivate($info, $this->input->post('degree')+1);
                $this->faculty->setrecord($info);
                
                }
                
            redirect(base_url().'Rpc/loadallfaculties','refresh');
	}
	else{
	    
	    $this->load->view('faculty/errormessage');
	}
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>