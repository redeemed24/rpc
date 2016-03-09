<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/style.css'; ?>" />
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/menu.css'; ?>" />
<script type="text/javascript">
<!--//---------------------------------+
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// --------------------------------->
$(document).ready(function()
{
	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#modules p.menu_head").click(function()
        {
	   $(this).next("div.menu_body").slideToggle(100).siblings("div.menu_body").slideUp("fast");
            $(this).siblings();
	});
	
	$("#backup").click(function(event) {
                alert("The Database is Succesfully Backup!");
            });
});
</script>

</head>
<body>
   
   
<div id="container">
      <div id="banner">
      </div>
      
      
      
      <div id="body">
         <div id="left">
                <div class="welcome">Welcome, &nbsp&nbsp<?php $user = array();echo $this->session->userdata('name').br(1); ?>
	 <?php echo $this->session->userdata('userlevel_name');?></div>
         <div class="logout"><?php echo anchor('Rpc/loadlogout','[Logout]');?> | <?php echo anchor('Rpc/loadaccountsettings/'.$this->session->userdata('username'),'[Account Settings]');?></div>
            
         <div id="modules" class="menu_list">
           <?php include '../application/views/menu_condition.php';?>
            </div>
         </div>
         <div id="breadcrumpic">
            <div class="breadcrum">
            <?php echo anchor('Rpc/index','Main');?> >
            <?php echo"User Management";?> >>
            <?php echo "View Users";?> >>>
            <?php echo"Update User";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
         <div id="head"><p>Update User
	 <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(94)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
         <br>
         <?php

$user_information = array(); // stores user information from database
$user_accountinfo = array(); // stores user account info from database

$count = 0;


foreach($user_info as $userinfo){
   $user_information[$count++] = array ('user_fname' => $userinfo->user_fname,
                                        'user_mname' => $userinfo->user_mname,
                                        'user_lname' => $userinfo->user_lname,
                                        'user_gender'=> $userinfo->user_gender,
                                        'program_id'=> $userinfo->program_id,
                                        'user_username'=> $userinfo->user_username
                                        );
}

?>


<?php echo form_open('index.php/users/update_user/updatecommittee/'.$user_information[0]['user_username']); ?>


<?php //Holds the value of the changes in user's information
   $data = array( 'user_fname','user_mname',
                    'user_lname','user_gender','program_id',
                    'user_username','user_pass','user_pass1');
?>

<h5> Committee Name: </h5>
<?php echo $user_information[0]['user_fname']." ".$user_information[0]['user_mname']." ".$user_information[0]['user_lname'];
    echo form_hidden('user_username', $user_information[0]['user_username']); ?>

<br><br>
<h5>Program:</h5>

<?php
   $program_list = array();
   $count=0;
   foreach($program_data as $program1){
        if($program1->program_id== $user_information[0]['program_id']){
            echo $program1->program_name;
            break;
        }
      }
      
echo "<br><br>";
echo "<h5>"."Program to Rank:"."</h5>";

    $options = array();
    foreach($program_data as $program){
	 if($program->program_id != $user_information[0]['program_id']){
	    if($program->user_username == $user_information[0]['user_username']){ //Checks if the a program is assigned to the user
	    echo form_checkbox('options[]', $program->program_id, 'accept', TRUE); //If yes, check checkbox
	    }
	 else {
	    echo form_checkbox('options[]', $program->program_id); //Else, just output checkbox
	    }
    
	 echo $program->program_name."</br>";
      }
    }
?>

<br><br>
<?php echo form_submit('', 'Save Changes'); ?>
<?php echo form_close(); ?>
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
      </div>

</div>
   
   
</body>
</html>

