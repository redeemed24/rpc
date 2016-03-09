<?php

class User extends CI_Model{
    
    //Checks if the username is already taken
    //Gets all the user's info from the database
    function checkusername($user_username){
        $this->db->where('user_username', $user_username);
        return $this->db->get('users')->result();
    }
    
    //Gets userlevel from the database
    function getuserlevelid(){
        $this->db->where('userlevel_id !=', 4);
        return $this->db->get('userlevel')->result();
    }
    
    //Gets all the account information of a user
    function getuserinfo($user_username){
        $this->db->where('user_username', $user_username);
        return $this->db->get('account')->result();
    }
    
    //get user status, userlevel, userscompletename and username for view_users
    function getallusers(){
        $this->db->select('status, users.user_username, userlevel.userlevel_desc, users.user_lname, users.user_fname, users.user_mname');    
        $this->db->from('account');
        $this->db->where('account.userlevel_id !=', 4);
        $this->db->join('users', 'users.user_username = account.user_username');
        $this->db->join('userlevel', 'account.userlevel_id = userlevel.userlevel_id');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //Saves user information to the database
    function insertuser(){
        $this->load->model('programs/programs');
        
        $programs = array();
        $programs = $this->programs->getprograms();
        
        $program_id;
        $count=0;
        foreach($programs as $row){
            if($this->input->post('program')==$count){
                $program_id = $row->program_id;
                break;
            }
            $count++;
        }
        
        
        $user_data = array ('user_fname' => $this->input->post('user_fname'),
                            'user_mname' => $this->input->post('user_mname'),
                            'user_lname' => $this->input->post('user_lname'),
                            'user_gender' => $this->input->post('user_gender'),
                            'program_id' => $program_id,
                            'user_username' => $this->input->post('user_username')
                            );
        
        $this->db->insert('users',$user_data); // Insert user information to table user
        
        if($this->input->post('user_status')==1){
            $status = 0;
        }
        else{
            $status = 1;
        }
        
        $user_account = array ('user_username' => $this->input->post('user_username'),
                               'user_pass' => md5($this->input->post('user_pass')),
                               'userlevel_id'=>$this->input->post('userlevel_id')+1,
                               'status' => $status
                               );
        
        $this->db->insert('account', $user_account); // Insert user account information to table account

    }
    
    function updateuser($user_username){
        
        $user_pass;
        
        if($this->input->post('user_pass1')==NULL){
            $user_pass = $this->input->post('old_pass');
        }
        
        else{
            $user_pass = md5($this->input->post('user_pass1'));
        }
        
        /*
            foreach($this->getuserinfo($user_username) as $rows){
                if($rows->user_pass == $this->input->post('user_pass1')){
                    $user_pass = $rows->user_pass;
                }
                else{
                    $user_pass = md5($this->input->post('user_pass1'));
                }
            }
        */
            
         $user_data = array ('user_fname' => $this->input->post('user_fname'),
                            'user_mname' => $this->input->post('user_mname'),
                            'user_lname' => $this->input->post('user_lname'),
                            'user_gender' => $this->input->post('user_gender'),
                            'program_id' => $this->input->post('program')+1,
                            'user_username' => $this->input->post('user_username')
                            );
        
        $this->db->where('user_username', $user_username);
        $this->db->update('users',$user_data); // Insert user information to table user
        
        $user_account = array ('user_username' => $this->input->post('user_username'),
                               'user_pass' => $user_pass,
                               'userlevel_id'=>$this->input->post('userlevel_id')+1,
                               'status' => $this->input->post('user_status')
                               );
        
        $this->db->where('user_username', $user_username);
        $this->db->update('account', $user_account); // Insert user account information to table account
    }
    
    function updatepass($user_username){
        $pass = md5($this->input->post('user_pass1'));
        $this->db->set('user_pass', $pass);
        $this->db->where('user_username', $user_username);
        $this->db->update('account');
    }
    //update account
    function updateaccount($user_username){
    
         
         $user_data = array ('user_fname' => $this->input->post('user_fname'),
                            'user_mname' => $this->input->post('user_mname'),
                            'user_lname' => $this->input->post('user_lname'),
                            'user_gender' => $this->input->post('user_gender'),
                            'program_id' => $this->input->post('program')+1,
                            'user_username' => $this->input->post('user_username')
                            );
        
        $this->db->where('user_username', $user_username);
        $this->db->update('users',$user_data); // Insert user information to table user
        
        $user_account = array ('user_username' => $this->input->post('user_username'),
                               'userlevel_id'=>$this->session->userdata('userlevel_id'),
                               'status' => 1
                               );
        
        $this->db->where('user_username', $user_username);
        $this->db->update('account', $user_account); // Insert user account information to table account
    }
    
    //update status for a user
    function updatestatus($status, $user_username){
        $this->db->set('status', $status);
        $this->db->where('user_username', $user_username);
        $this->db->update('account');
    }
    
    //search user
    function searchuser(){
        $keywords = $this->input->post('keywords');
        $userlevel = $this->input->post('userlevel');
        
        /*$this->db->select('status, users.user_username, userlevel.userlevel_desc, users.user_lname, users.user_fname, users.user_mname');    
        $this->db->from('account');
        $this->db->join('users', 'users.user_username = account.user_username');
        $this->db->join('userlevel', 'account.userlevel_id = userlevel.userlevel_id');*/
        
        $append;
        if($userlevel == 0){
            if($keywords == NULL){
                $append = "";
            }
            else{
              //$this->db->where('users.user_lname', $keywords);
              $append = " where users.user_lname = '$keywords' or users.user_username = '$keywords' or users.user_fname = '$keywords'";
            } 
        }
        
        else{
            if($keywords == NULL){
                //$this->db->where('account.userlevel_id', $userlevel);
                $append = " where account.userlevel_id = '$userlevel'";
            }
            else{
                /*$this->db->where('account.userlevel_id', $userlevel);
                $this->db->where('users.user_lname', $keywords);*/
                $append = " where account.userlevel_id = '$userlevel' AND (users.user_lname = '$keywords' or users.user_fname = '$keywords' or users.user_username = '$keywords')";
            }
        }
        
        //$query = $this->db->get();
        $query = $this->db->query("select status, users.user_username, userlevel.userlevel_desc, users.user_lname, users.user_fname, users.user_mname
           from account inner join users on users.user_username = account.user_username
           inner join userlevel on account.userlevel_id = userlevel.userlevel_id $append ORDER BY users.user_lname, users.user_fname ASC");
        return $query->result_array();
        
    }
    
    function validatelog(){
        $this->db->select();
        $this->db->from('account');
        $this->db->join('users', 'users.user_username = account.user_username');
        $this->db->join('userlevel', 'userlevel.userlevel_id = account.userlevel_id');
        $this->db->where('account.user_username', $this->input->post('username'));
        $this->db->where('account.user_pass', md5($this->input->post('password')));
        $this->db->where('account.status', 1);
        
        return $this->db->get()->result();
    }
    
    function resetpassword($user_username, $user_pass){
        $this->db->set('user_pass', $user_pass);
        $this->db->where('user_username', $user_username);
        $this->db->update('account');
    }
    
    function loadusersforchair(){
        $this->db->select('users.user_fname, account.userlevel_id, users.user_mname, users.user_lname, program.program_name, users.user_username');
        $this->db->from('users');
        $this->db->join('account', 'users.user_username = account.user_username');
        $this->db->join('program', 'users.program_id = program.program_id');
        $this->db->where('account.status', 1);
        $this->db->where('account.userlevel_id', 3);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function searchcom(){
          
        $keywords = $this->input->post('keywords');
        
        $this->db->select('account.status, users.user_username, userlevel.userlevel_desc, users.user_lname, users.user_fname, users.user_mname, program.program_id, program.program_name, account.userlevel_id');    
        $this->db->from('account');
        $this->db->join('users', 'users.user_username = account.user_username');
        $this->db->join('userlevel', 'account.userlevel_id = userlevel.userlevel_id');
        $this->db->join('program', 'users.program_id = program.program_id');
        $this->db->where('account.userlevel_id', 3);
        $this->db->where('account.status', 1);
        $this->db->where('users.user_fname', $keywords);
        $this->db->or_where('users.user_mname', $keywords);
        $this->db->or_where('users.user_lname', $keywords);
        $this->db->or_where('users.user_username', $keywords);
        $this->db->or_where("CONCAT_WS(' ', users.user_fname, users.user_mname, users.user_lname) = '$keywords'");
        $this->db->or_where("CONCAT_WS(' ', users.user_fname, users.user_mname) = '$keywords'");
        $this->db->or_where("CONCAT_WS(' ', users.user_fname, users.user_lname) = '$keywords'");
        $this->db->or_where("CONCAT_WS(' ', users.user_mname, users.user_lname) = '$keywords'");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function updatevaluated($username){
        
        $this->db->where('user_username', $username);
        $this->db->set('user_username', $this->input->post('user_username'));
        $this->db->update('report');
        
        $this->updatechange($username, $this->input->post('user_username'));
    }
    
    function updatechange($old_username, $new_username){
        
        $this->db->where('user_username', $old_username);
        $this->db->set('updated', $new_username);
        $this->db->update('report');
    }
}
?>