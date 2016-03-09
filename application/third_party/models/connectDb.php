<?php

class connectDb extends CI_Model{
    public function getdatabase(){
        $query = $this->db->query("SELECT * FROM account");
        
        return $query->result();
    }
}

?>