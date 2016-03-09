<?php
class Login extends CI_Controller{
    function validatelogs(){
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        
        if($this->form_validation->run()==FALSE){ //checks valdiation rules for the username and password
            $this->load->view('loginpage');
        }
        
        else{
            $this->load->model('users/user');
        
            $this->form_validation->set_rules('username', 'username', 'callback_checkexist');
            if($this->form_validation->run()==TRUE){ //if exist
            $result = array();
            $result = $this->user->validatelog(); //checks db if username exists and matches the password and the account status is activated
	    $result['user_data']= $this->user->validatelog();
            
            foreach($result['user_data'] as $row){ //stores user info to an array for session
                $user_info = array('username'=> $row->user_username,
                                   'userlevel_id' => $row->userlevel_id,
                                   'program_id'=>$row->program_id,
                                   'name'=> $row->user_fname."!",
				   'userlevel_name'=> $row->userlevel_desc,
                                   'login'=>1); 
            }
            
            $this->session->set_userdata($user_info);
            $this->load->model('schoolyear/schoolyear');
            $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
            
              if($this->session->userdata('userlevel_id')==1){
                     $this->load->view('main', $data);
                     //echo "Load menus & pages for Human Resource";
              }
              
              else if($this->session->userdata('userlevel_id')==2){
                     $this->load->view('main', $data);
                     //echo "Load menus & pages for Chairperson";
              }
              
               else if($this->session->userdata('userlevel_id')==3){
                     $this->load->view('main', $data); //done
                     //echo "Load menus & pages for Committee";
              }
	      
	       else if($this->session->userdata('userlevel_id')==4){
                     $this->load->view('main', $data); //done
                     //echo "Load menus & pages for Committee";
              }
              
              else{
                $this->load->view('loginpage');
              }
              
            }
        
            else{// does not exist
            $this->load->view('loginpage'); //load page back to login page
            }
        }
        
    }
    
    function checkexist($username){
	  $result = array();
          $result = $this->user->validatelog(); //checks db if username exists and matches the password and the account status is activated
    
	  if($result!=NULL){
	    return TRUE;
	  }
	  else{
	    $this->form_validation->set_message('checkexist', 'Incorrect Username or Password.');
	    return FALSE;
	  }
    }
}
?>