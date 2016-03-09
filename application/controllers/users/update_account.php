<?php

class Update_account extends CI_Controller{
    
    
    function loadchangepass($user_username){
        if($this->session->userdata('login')==1){
            
          $this->load->model('users/user');
          $this->load->model('programs/programs');
          $this->load->model('schoolyear/schoolyear');
          
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['user_info'] = $this->user->checkusername($user_username); //get user info
        $data['user_account'] = $this->user->getuserinfo($user_username); //get account info
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
        $this->load->view('users/change_pass', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function changepass($user_username){
         
         
        if($this->session->userdata('login')==1){
         $this->load->model('users/user');
         $this->load->library('form_validation');
         $this->form_validation->set_rules('user_pass', 'user_pass', 'callback_userpass_check'); // if old password is correct
            
            if($this->form_validation->run()==TRUE){
                $this->form_validation->set_rules('user_pass1', 'user_pass2', 'callback_userpass1_check'); //if new password & confirm password matches
                if($this->form_validation->run()==TRUE){
                  $this->user->updatepass($user_username);
                  $this->loadchangepass($user_username);
                }
                else{
                    $this->loadchangepass($user_username);
                }
             }
             else{
                   $this->loadchangepass($user_username);
             }
        }
        else{
            $this->load->view('loginpage');  
        }
    }
    
    function updateaccount($user_username){
        if($this->session->userdata('login')==1){
       $this->load->model('users/user');
       $this->load->model('programs/programs');
       
       $this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
        
        
       
       //Username is changed
       if($this->input->post('user_username')!=$user_username){
             $this->form_validation->set_rules('user_username', 'user_username', 'callback_username_check');
            
            if($this->form_validation->run()==TRUE){    
                  $this->user->updateaccount($user_username);
                  $this->programs->changerankusername($user_username);
                  $this->user->updatevaluated($user_username);
                  
                  $this->session->sess_destroy();
                  $this->reloadlogin();
             }
             else{
                $this->loadupdateaccount($user_username);
             }
       }
       
       //No changes
       else{
             $this->user->updateaccount($user_username);
             $this->loadupdateaccount($user_username);
       }

}
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    
     function username_check($username){
    
    if($this->session->userdata('login')==1){
    $this->load->model('users/user');
       if($this->user->checkusername($username)!=NULL){
        $this->form_validation->set_message('username_check', 'Username is already exist. Please input another username.');
        return FALSE;
       }
    
       else{
        return TRUE; 
       }
       
       
       
}
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function userpass_check($userpass){
        if($this->session->userdata('login')==1){
           
         if(md5($this->input->post('user_pass'))!=$this->input->post('old_pass')){
            $this->form_validation->set_message('userpass_check', 'Old password is incorrect.');
            return FALSE;
         }
         
         else{
            return TRUE;
         }
         
    
}
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function userpass1_check($userpass){
        $pass = strlen($this->input->post('user_pass1'));
        if($this->session->userdata('login')==1){
           
         if(md5($this->input->post('user_pass1'))!=md5($this->input->post('user_pass2'))){
            $this->form_validation->set_message('userpass1_check', 'Passwords do not matched.');
            return FALSE;
         }
         
         else if($pass < 8){
          $this->form_validation->set_message('userpass1_check', 'Passwords must be minimum of 8 characters!.');
            return FALSE;
         }
         
         
         else{
            $this->form_validation->set_message('userpass1_check', 'Password has been sucessfully change!.');
            return TRUE;
         }
         
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadupdateaccount($user_username){
        if($this->session->userdata('login')==1){
        $this->load->model('users/user');
        $this->load->model('programs/programs');
        $this->load->model('schoolyear/schoolyear');
        
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['user_info'] = $this->user->checkusername($user_username); //get user info
        $data['user_account'] = $this->user->getuserinfo($user_username); //get account info
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
        $this->load->view("users/update_account", $data);
        
}
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function reloadlogin(){
        if($this->session->userdata('login')==1){
        $this->load->view('reloginpage');       
        }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>