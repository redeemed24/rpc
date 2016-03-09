<?php

class Add_user extends CI_Controller{
 
    
    //Add user information to the database and assign each program to a committee
      function adduser(){
       if($this->session->userdata('login')==1){
       $this->load->model('users/user');
       $this->load->model('programs/programs');
       $this->load->model('schoolyear/schoolyear');
       //Checks if the username is still available
       
        $this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('user_username', 'user_username', 'callback_username_check');
        $this->form_validation->set_rules('user_pass', 'user_pass', 'callback_userpass_check');
        
       //if($this->user->checkusername($this->input->post('user_username'))==NULL){
       if($this->form_validation->run()==TRUE){
       $this->user->insertuser(); // If yes, insert user information to the database
       $this->programs->rankprogram(); // assign programs to each commitee for ranking
       print_r($this->input->post('options'));
       //redirect(base_url().'Rpc/loadallusers','refresh');
       }
       else{
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       $data['program_data'] = $this->programs->getprograms(); // get all the programs
       $data['userlevel_data'] = $this->user->getuserlevelid(); // userlevels(Human Resource, Chaiperson, Commitee)
       $this->load->view("users/add_users", $data);// If username is already taken, display error message and return to adduser page
       }
       
       
}
	else{
	    $this->load->view('loginpage');   
	}
    }
    
    function username_check($username){
  
    $this->load->model('users/user');
       if($this->user->checkusername($this->input->post('user_username'))!=NULL){
        $this->form_validation->set_message('username_check', 'Username is already exist. Please input another username.');
        return FALSE;
       }
    
       else{
        return TRUE; 
       }
    }
    
       function userpass_check($userpass){
         $pass = strlen($this->input->post('user_pass'));
         if($this->input->post('user_pass')!=$this->input->post('user_pass1'))
         {
            $this->form_validation->set_message('userpass_check', 'Passwords did not match!.');
            return FALSE;
         }
         else if($pass < 8){
          $this->form_validation->set_message('userpass_check', 'Passwords must be minimum of 8 characters!.');
            return FALSE;
         }
         else{
           // redirect(base_url().'Rpc/loadadduser','refresh');
            return TRUE;
         }

         
         //else{
         //   $this->load->view('loginpage');
         //}
    }
    
    } 