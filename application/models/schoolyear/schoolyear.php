<?php

class Schoolyear extends CI_Model{
    function getschoolyear(){
        $this->db->where('status', 1);
        return $this->db->get('sy')->result();
    }
    
    function descschoolyear(){
        $this->db->order_by('SY_id', 'DESC');
        return $this->db->get('sy')->result();
    }
    
    function getlast(){
        $this->db->select_max('sy1');
        $query = $this->db->get('sy');
        return $query->result();
    }
    
    function getallschoolyear(){
        //$this->db->order_by('SY_id', 'DESC');
        return $this->db->get('sy')->result();
    }
    
    function insertschoolyear(){
        $details = $this->getlast();
        
        $sy1; $sy2;
        foreach($details as $row){
            $sy1 = $row->sy1+1;
            $sy2 = $row->sy1+2;
        }
        $data = array('SY_desc'=>$sy1."-"."$sy2", 'status'=>0, 'sy1'=>$sy1, 'sy2'=>$sy2);
        $this->db->insert('sy', $data);
    }
    
    function setschoolyear1($old){
        $this->db->set('status', 0);
        $this->db->where('SY_id', $old);
        $this->db->update('sy');
    }
    
     function setschoolyear2($new){
        $this->db->set('status', 1);
        $this->db->where('SY_id', $new);
        $this->db->update('sy');
    }
    
    function getthisschoolyear($id){
        $this->db->where('SY_id', $id);
        return $this->db->get('sy')->result();
    }
    
    function updatesy(){
        $this->db->set('SY_desc', $this->input->post('SY_desc'));
        $this->db->where('SY_id', $this->input->post('SY_id'));
        $this->db->update('sy');
    }
}
?>