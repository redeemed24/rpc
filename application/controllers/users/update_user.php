<?php

class Update_user extends CI_Controller{
    
    //Saves all the updated information of a user form views->update_users
    function updateuser($user_username){
      if($this->session->userdata('login')==1){
       $this->load->model('users/user');
       $this->load->model('programs/programs');
       
       $this->load->helper(array('form', 'url'));
       $this->load->library('form_validation');
       
       $this->form_validation->set_rules('user_username', 'user_username', 'callback_username_check');
       
       if($this->input->post('user_username')!=$user_username && $this->form_validation->run() == TRUE/*$this->user->checkusername($this->input->post('user_username'))==NULL*/){  //Checks if the new username is still available
        $this->user->updateuser($user_username); // If yes, insert user information to the database
        $this->programs->updaterankprogram($user_username); // assign programs to each commitee for ranking
        $this->programs->rankprogram();
        $this->user->updatevaluated($user_username);
        
        $this->reloadpage($this->input->post('user_username'));
       }
       
       else if($this->input->post('user_username')!=$user_username && $this->form_validation->run() == FALSE/*$this->user->checkusername($this->input->post('user_username'))!=NULL*/){  //Checks if the new username is still available
       
       $this->reloadpage($user_username);
       }
       
       else if($this->input->post('user_username')==$user_username){ // If username is not changed
        $this->user->updateuser($user_username); // update user information to the database
        $this->programs->updaterankprogram($user_username); // assign programs to each commitee for ranking
        $this->programs->rankprogram();
        
         $this->reloadpage($user_username);
       }
       
         else{
         $this->reloadpage($user_username);
       //$this->load->view('login'); // If username is already taken, display error message and return to adduser page
            }
       }
       
      else{
	    $this->load->view('loginpage');  
      }
        
    }
     function resetpass($user_username){
      if($this->session->userdata('login')==1){
      $this->load->model('users/user');
      $this->user->resetpassword($user_username, md5('1234'));
      redirect(base_url().'Rpc/loadallusers','refresh');
      }
	else{
	    $this->load->view('loginpage');  
	}
      }
    
       function updatecommittee($user_username){
      if($this->session->userdata('login')==1){
       $this->load->model('programs/programs');
       $this->programs->updaterankprogram($user_username); // assign programs to each commitee for ranking
       $this->programs->rankprogram();
       redirect(base_url().'Rpc/loadalluserschaiperson','refresh');
       }
	else{
	    $this->load->view('loginpage');  
	}
      }
   
    function username_check($username){
    $this->load->model('users/user');
       if($this->user->checkusername($username)!=NULL){
        $this->form_validation->set_message('username_check', 'Username is not available. Please input another username.');
        return FALSE;
       }
    
       else{
        return TRUE; 
       }
    }
    
    
    function reloadpage($user_username){
      $this->load->model('users/user');
       $this->load->model('programs/programs');
       $this->load->model('schoolyear/schoolyear');
       
        $data['user_info'] = $this->user->checkusername($user_username); //get user info
        $data['user_account'] = $this->user->getuserinfo($user_username); //get account info
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $this->load->view('users/update_users', $data);
    }
 
}
?>