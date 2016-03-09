<?php

class update_item extends CI_Controller{
    function updateitem()
    {
    if($this->session->userdata('login')==1){
    $this->load->model('qualification/qualifications');
    $this->qualifications->edititem();
    redirect(base_url().'Rpc/loadupdateitems/'.$this->input->post('item_id'),'refresh');
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
}

?>