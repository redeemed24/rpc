<?php

class Programs extends CI_Model{
    
    function insertprogram(){
        $data = array('program_name'=>$this->input->post('program_name'), 'status'=>1);
        $this->db->insert('program', $data);
    }
    
    function checkprogram($program_name, $val, $id){
        if($val==0){
            $this->db->where('program_id !=', $id);
        }
        
        $this->db->where('program_name', $program_name);
        return $this->db->get('program')->result();
    }
    function getprograms(){
        //$this->db->where('status !=', 0);
        return $this->db->get('program')->result();
    }
    
    function loadprograms(){
        return $this->db->get('program')->result();
    }
    
    function pickprogram($id){
        $this->db->select('program.program_name, users.user_lname, users.user_fname, users.user_mname, program.program_id, program.user_username');
        $this->db->from('program');
        $this->db->join('users', 'program.user_username = users.user_username', 'left');
        $this->db->where('program.program_id', $id);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function updateprogram($id){
        $this->db->set('program_name', $this->input->post('program_name'));
        $this->db->where('program_id', $id);
        $this->db->update('program');
    }
    
    function removeprogram(){
        $program = array($this->input->post('options'));
        
        for($i=0; $i<count($program[0]); $i++){
            $this->db->set('status', 0);
            $this->db->where('program_id', $program[0][$i]);
            $this->db->update('program');
        }
    }
    
    function getlistprogram(){
        $this->db->select('program.program_name, users.user_lname, users.user_fname, users.user_mname, program.program_id');
        $this->db->from('program');
        $this->db->join('users', 'program.user_username = users.user_username', 'left');
        $this->db->where('program.status !=', 0);
        $this->db->order_by('program_name', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //Assigns a new user to rank a program
    function rankprogram(){
    $program = array($this->input->post('options'));
    
    for($i=0; $i<count($program[0]); $i++){
        $this->db->set('user_username',$this->input->post('user_username'));
        $this->db->where('program_id', $program[0][$i]);
        $this->db->where('program_id !=', $this->input->post('program')+1);
        $this->db->update('program');
    }
    }
    
    //Get all assigned program to rank of each user
    function getassignedprogram($user_username){
        $this->db->where('user_username', $user_username);
        $this->db->where('status !=', 0);
        return $this->db->get('program')->result();
    }
    
    //Re-assigns a user to rank a program with an old username
    function updaterankprogram($user_username){
    $old_assign = array();
    $new_assign = $this->input->post('options'); //updated checkboxes
    
    $count = 0;
    foreach($this->getassignedprogram($user_username) as $rows){ 
        $old_assign [$count++] = $rows->program_id; 
        }
     
    
    $a = 0; 
    if(count($old_assign)>=count($new_assign)){// compares the number of data in arrays for the limit of the loop
        $a = count($old_assign);
        for($count=count($new_assign); $count<$a; $count++){
            $new_assign[$count] = 0;
        }
    }
    
    else if(count($new_assign)>count($old_assign)){// compares the array count of the 2 arrays for the limitation of the loop
        $a = count($new_assign);
        for($count=count($old_assign); $count<$a; $count++){
            $old_assign[$count] = 0;
        }
    }
    
    for($count1=0; $count1<$a; $count1++){
        $value=0;
        for($count2=0; $count2<$a; $count2++){
            if($old_assign[$count1]==$new_assign[$count2]){
                $value=1;
                goto start;
            }
            else{
                $save = $old_assign[$count1];
            }
        }
        
        if($value!=1){
                    $this->db->set('user_username', 0);
                    $this->db->where('program_id', $save);
                    $this->db->update('program');
        }
        
        start:
    }
    }
    
    function changerankusername($user_username){
        $this->db->set('user_username', $this->input->post('user_username'));
        $this->db->where('user_username', $user_username);
        $this->db->update('program');
    }
    
    function selectprogram(){
        $username = $this->session->userdata('username');
        $this->db->where('user_username', $username);
        return $this->db->get('program')->result();
    }
    
}
?>