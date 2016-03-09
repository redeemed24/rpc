<?php

class Ranks extends CI_Model{
    //Inserts rank to database
    function insertrank(){
    $result = array ('rank_name' => $this->input->post('rank_name'),
                     'degree_id' => $this->input->post('degree')+1,
                     'remarks' => $this->input->post('remarks'),
                     'status'=>1);
    
    $this->db->insert('rank', $result);
    }
    
    function sortsubrank($rank_id){
        $query = $this->db->query("select * from subrank where rank_id = '$rank_id' and status = '1' ORDER BY min_points ASC");
        return $query->result();
    }
    
    function updatesortrank($rank_id){
        $subrank = $this->sortsubrank($rank_id);
        
        $num = array();
        $count = 0;
        foreach($subrank as $row){
            $num[$count++] = $row->subrank_id;
        }
        
        for($i=0; $i<$count; $i++){
            $this->db->set('subrank_num', $i+1);
            $this->db->where('subrank_id', $num[$i]);
            $this->db->update('subrank');
        }
        
        //print_r($num);
    }
    //Gets all the rank from database
    function viewrank(){
    $this->db->select('rank.rank_id, rank.rank_name, rank.remarks, degree.degree_desc');
    $this->db->from('rank');
    $this->db->join('degree', 'degree.degree_id = rank.degree_id', 'left');
    $this->db->where('rank_id !=', 0);
    $this->db->where('status !=', 0);
    //$this->db->order_by('subrank.min_points', 'asc');
    $query = $this->db->get();
    
    return $query->result_array();
    }
      
    //Get rank info for updating purposes
    function getrank($rank_id){
        $this->db->where('rank_id', $rank_id);
        return $this->db->get('rank')->result();
    }
    
    function updaterank($rank_id){
        $rank_data = array('rank_name'=>$this->input->post('rank_name'),
                           'degree_id'=>$this->input->post('degree')+1,
                           'remarks'=>$this->input->post('remarks'));
        
        $this->db->where('rank_id', $rank_id);
        $this->db->update('rank', $rank_data);
    }
    
    function searchrank($keywords){
    $this->db->select('rank.rank_id, rank.rank_name, rank.remarks, degree.degree_desc');
    $this->db->from('rank');
    $this->db->join('degree', 'degree.degree_id = rank.degree_id');
    $this->db->where('rank_name', $keywords);
    $this->db->where('status !=', 0);
    //$this->db->order_by('subrank.min_points', 'asc');
    $query = $this->db->get();
    
    return $query->result_array();
    }
    
    function insertsubrank($rank_id){
    $data = array('rank_id'=>$rank_id,
                      'subrank_num'=> $this->input->post('subrank_num'),
                      'min_points'=> $this->input->post('min_points'),
                      'max_points'=> $this->input->post('max_points'),
                      'status'=>1);
    
    $this->db->insert('subrank', $data);
    $this->updatesortrank($rank_id);
    }
    
    function viewsubrank(){
       $this->db->where('subrank_id !=', 0);
       $this->db->where('status !=', 0);
       $this->db->order_by('min_points', 'asc');
       $query = $this->db->get('subrank');
       return $query->result_array();
    }
    
    function getsubrank($id){
        $this->db->where('subrank_id', $id);
        return $this->db->get('subrank')->result();
    }
    
    function updatesubrank($id){
        $ranks = $this->viewrank();
        $count = 0;
        $rankid;
        foreach($ranks as $row){
            if($count == $this->input->post('rank')){
                $rankid = $row['rank_id'];
                break;
            }
            $count++;
        }
        $data = array('subrank_num'=>$this->input->post('subrank_num'),
                      'rank_id'=>$rankid,
                      'min_points'=>$this->input->post('min_points'),
                      'max_points'=>$this->input->post('max_points'));
        
        $this->db->where('subrank_id', $id);
        $this->db->update('subrank', $data);
        
        $this->updatesortrank($rankid);
    }
    
    function selectsubrank($rank_id){
        $this->db->where('rank_id', $rank_id);
        $this->db->where('status !=', 0);
        $this->db->order_by('min_points', 'asc');
        return $this->db->get('subrank')->result();
    }
    
    function removesubrank(){
        $subrank = array($this->input->post('options'));
        $ans = $this->getsubrank($subrank[0][0]);
        
        for($i=0; $i<count($subrank[0]); $i++){
            $this->db->set('status', 0);
            $this->db->where('subrank_id', $subrank[0][$i]);
            $this->db->update('subrank');
        }
        
        $rankid;
        foreach($ans as $row){
            $rankid = $row->rank_id;
            break;
        }
        
        $this->updatesortrank($rankid);
    }
    
    function removerank(){
        $rank = array($this->input->post('options'));
        
        for($i=0; $i<count($rank[0]); $i++){
            $this->db->set('status', 0);
            $this->db->where('rank_id', $rank[0][$i]);
            $this->db->update('rank');
        }
    }
    
    function checkexist($val, $subrank_id){
        $min = $this->input->post('min_points');
        $max = $this->input->post('max_points');
        
        if($val==0){
        $query = $this->db->query("select * from subrank inner join rank on subrank.rank_id = rank.rank_id where ((subrank.min_points<='$min' and subrank.max_points>='$min') or (subrank.min_points<='$max' and subrank.max_points>='$max')) and subrank.status=1 and rank.status = 1");
        }
        
        else{
         $query = $this->db->query("select * from subrank inner join rank on subrank.rank_id = rank.rank_id where ((subrank.min_points<='$min' and subrank.max_points>='$min') or (subrank.min_points<='$max' and subrank.max_points>='$max')) and subrank.status=1 and subrank_id!= '$subrank_id' and rank.status = 1");
        }
        return $query->result();
    }
    
    function isrank($name, $rank_id){
        $this->db->where('rank_id !=', $rank_id);
        $this->db->where('rank_name', $name);
        $this->db->where('status', 1);
        return $this->db->get('rank')->result();
    }
}

?>