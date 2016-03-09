<?php

class Degree extends CI_Model{
    function readdegree(){
        return $this->db->get('degree')->result();
    }
}

?>