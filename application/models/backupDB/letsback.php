<?php

class letsback extends CI_Model{
    function BackupDatabase(){
        
        $prefs = array(
          'tables' => array(),
          'ignore' => array(),
          'format' => 'zip',
          'filename' => 'my_db_backup.sql',
          'add_drop' => TRUE,
          'add_insert' => TRUE,
          'newline' => "\n"
        );
        
       
        $this->load->dbutil($prefs);
        $backup =& $this->dbutil->backup($prefs);
        $this->load->helper('file');
        write_file('C:\Program Files/mybackup.zip', $backup);
        $this->load->helper('download');
        force_download('mybackup.zip');
        redirect(base_url().'Rpc/mainview','refresh');
    }
}
?>