<?php

class Search_qualification extends CI_Controller{
    function searchqualification(){
       if($this->session->userdata('login')==1){
       $this->load->model('qualification/qualifications');
       $data['qualification_data'] = $this->qualifications->searchqualification($this->input->post('keywords')); // get all the list of qualification ids
       $data['item_data'] = $this->qualifications->getitems(); // get all the list of itmes
       $this->load->view('qualifications/view_qualifications', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
}
?>