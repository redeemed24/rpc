<?php

class qualifications extends CI_Model
{

    //add a qualification
    function insertqualification()
    {       
        $data = array(
        'qualification_name' => $this->input->post('qualification_name'),
        'maxpoints' => $this->input->post('maxpoints'),
        'maxpercentage' => $this->input->post('maxpercentage'),'status'=>1
        );
        
        $this->db->insert('qualification',$data);
    }
    
    function checkexist($quali_name, $val, $id){
        if($val==1){
            $this->db->where('qualification_id !=', $id);
        }
        $this->db->where('qualification_name', $quali_name);
        $this->db->where('status', 1);
        return $this->db->get('qualification')->result();
    }
    
    //add an item
    function insertitem()
    {       
        $data = array(
        'item_name' => $this->input->post('item_name'), 'qualification_id' => $this->input->post('qual_id'),
        'status'=>1);
        
        $this->db->insert('item',$data);
    }
    
    //update qualification
    function editqualification()
    {       
        $data = array(
        'qualification_name' => $this->input->post('qualification_name'),
        'maxpoints' => $this->input->post('maxpoints'),
        'maxpercentage' => $this->input->post('maxpercentage')
        );
        $id = $this->input->post('qualification_id');
        
        $this->db->where('qualification_id',$id);
        $this->db->update('qualification',$data);
    }
    
    //update item
    function edititem()
    {
        /*$data = array('item_name'=>$this->input->post('item_name'),
                      'qualification_id'=>$this->input->post('qualification')+1);*/
        
        $quali = $this->getqualifications();
        $count = 0;
        $quali_id;
        
        foreach($quali as $row){
            if($this->input->post('qualification') == $count){
                $quali_id = $row->qualification_id;
            }
            $count++;
        }
        
        $this->db->set('item_name', $this->input->post('item_name'));
        $this->db->set('qualification_id', $quali_id);
        $this->db->where('item_id',$this->input->post('item_id'));
        $this->db->update('item');
    }
    
    //gets all the qualification for the dropdown in adding items
    function getqualifications(){
        $this->db->where('status !=', 0);
        $this->db->order_by('qualification_name', 'ASC');
        return $this->db->get('qualification')->result();
    }
    
    //gets all the items
    function getitems(){
        $this->db->where('status !=', 0);
        $this->db->order_by('item_name', 'ASC');
        return $this->db->get('item')->result();
    }
    
    function readqualification($id){
        $this->db->where('qualification_id', $id);
        return $this->db->get('qualification')->result();
    }
    
    function readitem($id){
        $this->db->where('item_id', $id);
        return $this->db->get('item')->result();
    }
  
    function searchqualification($keywords){
        $this->db->where('qualification_name', $keywords);
        $this->db->where('status !=', 0);
       return $this->db->get('qualification')->result();
    }
    
    function removeitem(){
        $item = array($this->input->post('options'));
        
        for($i=0; $i<count($item[0]); $i++){
        $this->db->where('item_id', $item[0][$i]);
        $this->db->set('status', 0);
        $this->db->update('item');   
        }
    }
    
    function allitems($id){
        $this->db->where('qualification_id', $id);
        $this->db->where('status !=', 0);
        $this->db->order_by('item_name', 'asc');
        return $this->db->get('item')->result();
    }
    
    function removequalification(){
        $qualification = array($this->input->post('options'));
        
        for($i=0; $i<count($qualification[0]); $i++){
            $this->db->set('status', 0);
            $this->db->where('qualification_id', $qualification[0][$i]);
            $this->db->update('qualification');
        }
    }
}
?>