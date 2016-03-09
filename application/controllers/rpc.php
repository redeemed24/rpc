<?php

class Rpc extends CI_Controller{
       
       function __construct(){
		parent::__construct();
		$this->load->model('users/user');
                $this->load->model('programs/programs');
                $this->load->model('qualification/qualifications');
                $this->load->model('degree/degree');
                $this->load->model('faculty/faculty');
                $this->load->model('ranking/ranks');
                $this->load->model('checklist/checklist');
                $this->load->model('schoolyear/schoolyear');
                $this->load->model('qualification/qualifications');
		$this->load->model('reports/reports');
	}
       
       function index(){
       
       if($this->session->userdata('login')!=1){
          $this->loadlogin();    
       }
       
       else{
	      $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
              if($this->session->userdata('userlevel_id')==1){
                     $this->load->view('main', $data);
                     //echo "Load menus & pages for Human Resource";
              }
              
              else if($this->session->userdata('userlevel_id')==2){
                     $this->load->view('main', $data);
                     //echo "Load menus & pages for Chairperson";
              }
              
               else if($this->session->userdata('userlevel_id')==3){
                     $this->load->view('main', $data); //done
                     //echo "Load menus & pages for Committee";
              }
	      
	      
               else if($this->session->userdata('userlevel_id')==4){
                     $this->load->view('main', $data); //done
                     //echo "Load menus & pages for SuperUsers";
              }
       }
       
       /*USER*/
       //$this->loadadduser(); //done
       //$this->loadupdateuser();
       //$this->loadallusers(); //checked and partially done // search user
       
       /*FACULTY*/
       //$this->loadaddfaculties(); //done 
       //$this->loadupdatefaculty();
       //$this->loadallfaculties(); //checked
       
       /*QUALIFICATION*/
       //$this->loadaddqualification(); //checked set rules & standards done
       //$this->loadupdatequalification(); // There is an error *this is not included in the menu*
       //$this->loadviewqualification(); //checked (view qualification)
       
       /*ITEMS*/
       //$this->loadupdateitems(); //There is an error *not included in the menu*
       //$this->loadadditem(); //There is an error *select a qualification then add an item*
       
       /*RANK*/
       //$this->loadaddrank(); //checked
       // $this->loadallrank(); //checked
       //$this->loadupdaterank();
       //$this->loadaddsubrank();
       
       /*RECORDS*/
       //$this->loadallfacultiesrecords(); //Update Code
       //$this->loadviewfacultyrecord($id, $syid);
       
       /*REPORTS*/
       //$this->loadreports();
       
       /*PROGRAM*/
       //$this->loadallprogram();
       //$this->loadupdateprogram($program_id);
       
       /*CHECKLIST*/
       //$this->samplechecklist(); //Update Code
       
       /*SCHOOL YEAR*/
       //$this->loadaddschoolyear();
       //$this->allschoolyear();
       }
       
       
       //Loads all the programs for the dropdown and checkboxes in the view('adduser.php') and the userlevels;
       function loadadduser(){
       //$this->load->model('users/user');
       //$this->load->model('programs/programs');
       if($this->session->userdata('login')==1){
       $data['program_data'] = $this->programs->getprograms(); // get all the programs
       $data['userlevel_data'] = $this->user->getuserlevelid(); // userlevels(Human Resource, Chaiperson, Commitee)
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view("users/add_users", $data);}
       
       else{
	      $this->load->view('loginpage');}
       }
       
       //Load view for add qualification
       function loadaddqualification(){
	      $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	      if($this->session->userdata('login')==1){
		     $this->load->view('qualifications/add_qualifications', $data);
	      }
	      else{
		      $this->load->view('loginpage');     
	      }
       }
       
       //Load view for add an item
       
       function loadadditem($qualification_id){
        //$this->load->model('qualification/qualifications');
	if($this->session->userdata('login')==1){
	      $data['value_data'] = $this->qualifications->readqualification($qualification_id);
	      $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	      $this->load->view('qualifications/add_items', $data);
	}
	 else{
		      $this->load->view('loginpage');     
	      }
       }
       
       //Load all the users
        function loadallusers(){
        //$this->load->model('users/user');
	if($this->session->userdata('login')==1){
	      $data['allusers_data'] = $this->user->getallusers();
	      $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
	      $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	       
	      if($this->session->userdata('userlevel_id')==1){
	      $this->load->view('users/view_users', $data);
	      }
	      
	      else if($this->session->userdata('userlevel_id')==4){
	      $this->load->view('users/allusers_superuser.php', $data);    
	      }
	}
	else{
	      $this->load->view('loginpage');
	}
       }
       
       //Load update user view
        function loadupdateuser($user_username){
        //$this->load->model('users/user');
        //$this->load->model('programs/programs');
	if($this->session->userdata('login')==1){
        $data['user_info'] = $this->user->checkusername($user_username); //get user info
        $data['user_account'] = $this->user->getuserinfo($user_username); //get account info
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	
	$this->load->view('users/update_users', $data);
	}
	else{
	    $this->load->view('loginpage');  
	}
    }
    
     //Load update status
    function loadupdatestatus($status, $user_username){
        //$this->load->model('users/user');
	if($this->session->userdata('login')==1){
        $this->user->updatestatus($status, $user_username);
	$this->loadallusers();
	}
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Load add faculty
    function loadaddfaculties(){ 
       //$this->load->model('programs/programs');
       //$this->load->model('degree/degree');
       if($this->session->userdata('login')==1){
       $data['program_data'] = $this->programs->getprograms(); // get all the programs
       $data['degree_data'] = $this->degree->readdegree(); // get all the degree
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('faculty/add_faculties', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    
    //Load all faculties
    function loadallfaculties(){
       //$this->load->model('faculty/faculty');
       if($this->session->userdata('login')==1){
       $data['faculty_data'] = NULL;
       $data['program_data'] = $this->programs->loadprograms(); // get all the programs
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('faculty/view_faculties', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}

    }
    
    //Load update a faculty's information view
    function loadupdatefaculty($faculty_id){
      //$this->load->model('faculty/faculty');
      //$this->load->model('programs/programs');
      //$this->load->model('degree/degree');
      if($this->session->userdata('login')==1){
      $data['degree_data'] = $this->degree->readdegree(); // get all the degree
      $data['program_data'] = $this->programs->getprograms(); // get all the programs
      $data['faculty_data'] = $this->faculty->selectfaculty($faculty_id); // get all faculty info
      $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
      
      $this->load->view('faculty/update_faculties', $data);
      }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Add rank
    function loadaddrank(){
       if($this->session->userdata('login')==1){
       //$this->load->model('degree/degree');
       $data['degree_data'] = $this->degree->readdegree(); // get all the degree
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('ranking/add_rank', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Update qualification
    function loadupdatequalification($id){
       //$this->load->model('qualification/qualifications');
       if($this->session->userdata('login')==1){
       $data['qualification_data'] = $this->qualifications->readqualification($id); // get all the list of qualification ids
       $data['item_data'] = $this->qualifications->allitems($id);
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('qualifications/update_qualifications', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Update items
    function loadupdateitems($id){
       //$this->load->model('qualification/qualifications');
       if($this->session->userdata('login')==1){
       $data['qualification_data'] = $this->qualifications->getqualifications(); // get all the list of qualification name
       $data['item_data'] = $this->qualifications->readitem($id); // get all the list of itmes
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('qualifications/update_items', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //View qualification
    function loadviewqualification(){
       //$this->load->model('qualification/qualifications');
       if($this->session->userdata('login')==1){
       $data['qualification_data'] = $this->qualifications->getqualifications(); // get all the list of qualifications
       $data['item_data'] = $this->qualifications->getitems(); // get all the list of itmes
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('qualifications/view_qualifications', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //View Rank
    function loadallrank(){
       //$this->load->model('ranking/ranks');
       if($this->session->userdata('login')==1){
       $data['rank_data'] = $this->ranks->viewrank();
       $data['subrank_data'] = $this->ranks->viewsubrank();
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('ranking/view_rank',$data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Load view for update rank
    function loadupdaterank($rank_id){
       //$this->load->model('ranking/ranks');
       //$this->load->model('degree/degree');
       if($this->session->userdata('login')==1){
       $data ['subrank_data'] = $this->ranks->selectsubrank($rank_id);
       $data['rank_data'] = $this->ranks->getrank($rank_id);
       $data['degree_data'] = $this->degree->readdegree(); // get all the degree
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('ranking/update_rank', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Load view for adding a subrank
    function loadaddsubrank($rank_id){
       //$this->load->model('ranking/ranks');
       if($this->session->userdata('login')==1){
       $data['rank_data'] = $this->ranks->getrank($rank_id);
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('ranking/add_subrank', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    //Load update subrank
    function loadupdatesubrank($subrank_id){
       //$this->load->model('ranking/ranks');
       if($this->session->userdata('login')==1){
       $data ['subrank_data'] = $this->ranks->getsubrank($subrank_id);
       $data ['rank_data'] = $this->ranks->viewrank();
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('ranking/update_subrank', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function samplechecklist($id){
       //$this->load->model('checklist/checklist');
      //$this->load->model('schoolyear/schoolyear');
      //$this->load->model('qualification/qualifications');
      //echo $this->uri->segment(3);
      if($this->session->userdata('login')==1){
      /*$this->load->library('pagination');
      
      $config['base_url'] = 'http://localhost:8080/RPC/public_html/rpc/samplechecklist';
      $row =  $this->checklist->countres();
      
      $var;
      foreach($row as $row1){
        $var[0]=array('counta'=>$row1->counta);
      }
      
      $config['total_rows'] = $var[0]['counta'];
      $config['per_page'] = 1;
      $config['num_links'] = 20;
		
      $this->pagination->initialize($config);*/
      $data['school_year'] = $this->schoolyear->getschoolyear();//Load current school year
      $data['qualification_data'] = $this->qualifications->getqualifications(); // get all the list of qualifications
      $data['item_data'] = $this->qualifications->getitems(); // get all the list of itmes
      $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
      //$data['faculty_data'] = $this->checklist->getfaculties($config['per_page'], $this->uri->segment(3)); // get all the list of itmes
      
      $data['faculty_data'] = $this->faculty->sfaculty($id);
      $this->load->view('checklist/samplechecklist', $data);
      }
       else{
	    $this->load->view('loginpage');  
	}
    }
    
    function listchecklist(){
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       $data['faculty_data'] = $this->faculty->loadfaculties();
        $this->load->view('checklist/listchecklist', $data);
    }
    
    //Load all faculties
    function loadallfacultiesrecords(){
       //$this->load->model('faculty/faculty');
       //$this->load->model('schoolyear/schoolyear');
       if($this->session->userdata('login')==1){
       $data['program_data'] = $this->programs->getprograms(); // get all the programs
       $data['all_school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['school_year'] = $this->schoolyear->getschoolyear(); //get current school year
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       if($this->session->userdata('userlevel_id')==1){
	      //$data['faculty_data'] = $this->faculty->getallfaculties(); //get all faculties
	      $data['faculty_data'] = NULL;
	       $this->load->view('checklist/viewrecords', $data);
       }
       
       else if($this->session->userdata('userlevel_id')==2){
	      //$data['faculty_data'] = $this->faculty->getallfacultiesforchair();
	      $data['faculty_data'] = NULL;
	       $this->load->view('checklist/viewrecords', $data);
       }
       
       /*else if($this->session->userdata('userlevel_id')==3){
	      $data['faculty_data'] = $this->faculty->getrankedfaculties();
       }*/
       
        else if($this->session->userdata('userlevel_id')==3){
       $assigned = $this->programs->selectprogram();
       $count = 0;
       foreach($assigned as $row){
	      //echo $row->program_id;
	      $count++;
       }
       
        $data['assigned_program'] = $this->programs->selectprogram();
        $data['program_data'] = $this->programs->loadprograms(); // get all the programs
       
       if($count>1){
          $data['faculty_data'] = NULL;
	   $this->load->view('checklist/multiple_records', $data);
       }
       
       else if($count<=1){
         $data['faculty_data'] = $this->checklist->getassignedrecord();
	 $this->load->view('checklist/assigned_record', $data);
       }
       }
       }
	else{
	    $this->load->view('loginpage');  
	}
       //$this->load->view('checklist/viewrecords', $data);
    }
    
    function loadviewfacultyrecord($id, $syid){
       //$this->load->model('checklist/checklist');
       //$this->load->model('faculty/faculty');
       //$this->load->model('schoolyear/schoolyear');
       if($this->session->userdata('login')==1){
       $data['totalrecord_data'] = $this->checklist->readrecord($id, $syid); //get total points for each qualification
       $data['faculty_data'] = $this->faculty->selectfaculty($id); //get faculty info
       $data['previous_rank'] = $this->reports->previousrank($id, $syid); //get previous rank
       $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['qualification_data'] = $this->checklist->getqual($id, $syid); //get qualification id for that school year
       $data['record_data'] = $this->checklist->getrecord($id, $syid); //get records for that school year inner join qualification table for viewing
       $data['current_schoolyear'] = $this->schoolyear->getschoolyear();
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	
       $this->load->view('checklist/editrecord', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadreports(){
       //$this->load->model('programs/programs');
       //$this->load->model('schoolyear/schoolyear');
       if($this->session->userdata('login')==1){
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
	
       if($this->session->userdata('userlevel_id')==1){
       $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['program_data'] = $this->programs->loadprograms(); // get all the programs
       $data['report_data'] = NULL;
       
       $this->load->view('report/view_reports', $data);
       }
       
       else if($this->session->userdata('userlevel_id')==2){
       $data['program_data'] = $this->programs->loadprograms(); // get all the programs
       $data['report_data'] = NULL;
       $this->load->view('report/chair_reports', $data);
       }
       
       else if($this->session->userdata('userlevel_id')==3){
       $assigned = $this->programs->selectprogram();
       $count = 0;
       foreach($assigned as $row){
	      //echo $row->program_id;
	      $count++;
       }
       
        $data['assigned_program'] = $this->programs->selectprogram();
        $data['program_data'] = $this->programs->loadprograms(); // get all the programs
       
       if($count>1){
          $data['report_data'] = NULL;
	   $this->load->view('report/multiple_reports', $data);
       }
       
       else if($count<=1){
         $data['report_data'] = $this->reports->reportforchair();
	 $this->load->view('report/assigned_reports', $data);
       }
       }
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadaddprogram(){
       if($this->session->userdata('login')==1){
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       $this->load->view('program/add_program', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadallprogram(){
       //$this->load->model('programs/programs');
       if($this->session->userdata('login')==1){
       $data['program_data'] = $this->programs->getlistprogram();
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('program/view_program', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadupdateprogram($program_id){
       //$this->load->model('programs/programs');
       if($this->session->userdata('login')==1){
       $data['program_data'] = $this->programs->pickprogram($program_id);
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       
       $this->load->view('program/update_program', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadaddschoolyear(){
       if($this->session->userdata('login')==1){
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       $this->load->view('schoolyear/add_schoolyear', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function allschoolyear(){
       //$this->load->model('schoolyear/schoolyear');
       if($this->session->userdata('login')==1){
       //$data['schoolyear_data'] = $this->schoolyear->getallschoolyear();
       $data['schoolyear_data'] = $this->schoolyear->descschoolyear();
       $data['current_schoolyear'] = $this->schoolyear->getschoolyear();
       $data['schoolyear'] = $this->schoolyear->getschoolyear();
	
       $this->load->view('schoolyear/view_schoolyear', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadupdateschoolyear($id){
       if($this->session->userdata('login')==1){
       $this->load->model('schoolyear/schoolyear');
       $data ['schoolyear_data'] = $this->schoolyear->getthisschoolyear($id);
       $this->load->view('schoolyear/update_schoolyear', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadlogin(){
       $this->session->sess_destroy();
       $this->load->view('loginpage');
    }
    
    function loadlogout(){
       $this->session->sess_destroy();
       $this->load->view('loginpage');
       //$this->index();
    }
    
    function loadaccountsettings($user_username){
       if($this->session->userdata('login')==1){
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['user_info'] = $this->user->checkusername($user_username); //get user info
        $data['user_account'] = $this->user->getuserinfo($user_username); //get account info
        $data['program_data'] = $this->programs->getprograms(); // get all the programs
        $data['userlevel_data'] = $this->user->getuserlevelid(); // get all userlevels
        
	$this->load->view('users/update_account', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadalluserschaiperson(){
       $this->load->model('users/user');
       if($this->session->userdata('login')==1){
       //$data['user_account'] = $this->user->getuserinfo($user_username); //get account info
       
       //$this->load->model('schoolyear/schoolyear');
       $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
       $data['allusers_data'] = $this->user->loadusersforchair();
       $this->load->view('users/all_committee', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadupdateuserforchair($user_username){
       if($this->session->userdata('login')==1){
       
        //$this->load->model('schoolyear/schoolyear');
        $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
        $data['user_info'] = $this->user->checkusername($user_username); //get user info
	$data['program_data'] = $this->programs->getprograms(); // get all the programs
        $this->load->view('users/assign_committee', $data);
	}
	else{
	    $this->load->view('loginpage');  
	}
    }

    function backupDb(){
       if($this->session->userdata('login')==1){
       $this->load->model('backupDB/letsback');
       $this->letsback->BackupDatabase();
       }
	else{
	    $this->load->view('loginpage');  
	}
    }

    function mainview(){ //load the main view
    if($this->session->userdata('login')==1){
    //$this->load->model('schoolyear/schoolyear');
    $data['schoolyear_data'] = $this->schoolyear->getschoolyear();
    $this->load->view('main', $data);
    }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    // loads fpdf of qualifications
    function loadprintqualifications(){
       if($this->session->userdata('login')==1){
       define('FPDF_FONTPATH',$this->config->item('fonts_path'));
       $this->load->library('fpdflib');
       $this->load->model('fpdf');
       $this->load->model('qualification/qualifications');
       $data['qualification_data'] = $this->qualifications->getqualifications(); // get all the list of qualifications
       $data['item_data'] = $this->qualifications->getitems(); // get all the list of itmes
       $this->load->view('print/qualifications',$data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    // loads fpdf of ranks
    function loadprintranks(){
       if($this->session->userdata('login')==1){
       define('FPDF_FONTPATH',$this->config->item('fonts_path'));
       $this->load->library('fpdflib');
       $this->load->model('fpdf');
       $this->load->model('ranking/ranks');
       $data['rank_data'] = $this->ranks->viewrank();
       $data['subrank_data'] = $this->ranks->viewsubrank();
       $this->load->view('print/ranking',$data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    // loads fpdf of records
    function loadprintrecords($id, $syid){
       if($this->session->userdata('login')==1){
       define('FPDF_FONTPATH',$this->config->item('fonts_path'));
       $this->load->library('fpdflib');
       $this->load->model('fpdf');
       $this->load->model('qualification/qualifications');
       $data['totalrecord_data'] = $this->checklist->readrecord($id, $syid); //get total points for each qualification
       $data['faculty_data'] = $this->faculty->selectfaculty($id); //get faculty info
       $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['qualification_data'] = $this->checklist->getqual($id, $syid); //get qualification id for that school year
       $data['record_data'] = $this->checklist->getrecord($id, $syid); //get records for that school year inner join qualification table for viewing
       $data['current_schoolyear'] = $this->schoolyear->getschoolyear();
       $data['qualification_data'] = $this->qualifications->getqualifications(); // get all the list of qualifications
       $data['item_data'] = $this->qualifications->getitems(); // get all the list of itmes
       $data['previous_rank'] = $this->reports->previousrank($id, $syid); //get previous rank
       
       $this->load->view('print/records',$data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    // loads fpdf of reports(individual)
    function loadprintindividualreports($faculty_id, $sy_id){
       if($this->session->userdata('login')==1){
       define('FPDF_FONTPATH',$this->config->item('fonts_path'));
       $this->load->library('fpdflib');
       $this->load->model('fpdf');
       //$sy_id = $this->input->post('SY');
        
       $this->load->model('reports/reports');
       $this->load->model('checklist/checklist');
       $this->load->model('schoolyear/schoolyear');
       $this->load->model('faculty/faculty');
       
       $data['updated_data'] = $this->reports->getupdate($faculty_id, $sy_id);
       $data['faculty_data']= $this->faculty->selectfaculty($faculty_id);
       $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['record_data'] = $this->checklist->readrecord($faculty_id, $sy_id);
       $data['individual_data']= $this->reports->individualrep($faculty_id, $sy_id);
       $data['report_data'] = NULL;
       
       $this->load->view('print/individual_reports',$data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    // loads fpdf of reports(main)
    function loadprintallreports($val, $program_id, $sy_id){
       if($this->session->userdata('login')==1){
       define('FPDF_FONTPATH',$this->config->item('fonts_path'));
       $this->load->library('fpdflib');
       $this->load->model('fpdf');
       $this->load->model('reports/reports');
       $this->load->model('programs/programs');
       $this->load->model('schoolyear/schoolyear');
       
       $data['school_year'] = $this->schoolyear->getthisschoolyear($sy_id); //get school year
       $data['program_data'] = $this->programs->getprograms(); // get all the programs
       $data['report_data'] = $this->reports->loadprintallreport($val, $program_id, $sy_id);
       $this->load->view('print/all_reports', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
    function loadprintassigned($val, $program_id, $sy_id){
       if($this->session->userdata('login')==1){
       define('FPDF_FONTPATH',$this->config->item('fonts_path'));
       $this->load->library('fpdflib');
       $this->load->model('fpdf');
       $this->load->model('reports/reports');
       $this->load->model('programs/programs');
       $this->load->model('schoolyear/schoolyear');
       
       $data['school_year'] = $this->schoolyear->getallschoolyear(); //get school year
       $data['program_data'] = $this->programs->getprograms(); // get all the programs
       $data['report_data'] = $this->reports->loadprintassignedreport($val, $program_id, $sy_id);
       $this->load->view('print/all_reports', $data);
       }
	else{
	    $this->load->view('loginpage');  
	}
    }
    
}

?>