<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/style.css'; ?>" />
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/menu.css'; ?>" />
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery-1.9.1.min.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/demo.css'?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/styl.css'?>"/>
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/pschecker.js'; ?>"></script>

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


<script type="text/javascript">
//fadeout the validation
 $(document).ready(function(){
   setTimeout(function(){
  $("div.valid").fadeOut("slow", function () {
  $("div.valid").remove();
      });
 
}, 3000);
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
	       echo nbs(96)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	    
	 <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>"; ?>
	 
<?php

$user_information = array(); // stores user information from database
$user_accountinfo = array(); // stores user account info from database

$count = 0;


foreach($user_info as $userinfo){
   $user_information[$count++] = array ('user_fname' => $userinfo->user_fname,
                                        'user_mname' => $userinfo->user_mname,
                                        'user_lname' => $userinfo->user_lname,
                                        'user_gender'=> $userinfo->user_gender,
                                        'program_id'=> $userinfo->program_id);
}

$count = 0;
foreach($user_account as $useraccount){
    $user_accountinfo[$count++] = array('user_username'=>$useraccount->user_username,
                                        'userlevel_id' =>$useraccount->userlevel_id,
                                        'status'=> $useraccount->status,
                                        'user_pass'=> $useraccount->user_pass,
                                        'user_status'=>$useraccount->status);
    
}


?>

<?php echo form_open('index.php/users/update_account/updateaccount/'.$user_accountinfo[0]['user_username']); ?>


<?php //Holds the value of the changes in user's information
   $data = array( 'user_fname','user_mname',
                    'user_lname','user_gender','program_id',
                    'user_username','user_pass','user_pass1', 'user_pass2');
?>
<br><br>
<h5> First Name: </h5>
<?php
$val = $user_information[0]['user_fname'];
echo "<input type = 'text' name = '$data[0]' value = '$val' required>";
//echo form_input($data[0], $user_information[0]['user_fname']); ?>

<h5>Middle Name:</h5>
<?php
$val = $user_information[0]['user_mname'];
echo "<input type = 'text' name = '$data[1]' value = '$val' required>";
//echo form_input($data[1], $user_information[0]['user_mname']); ?>

<h5>Last Name:</h5>
<?php
$val = $user_information[0]['user_lname'];
echo "<input type = 'text' name = '$data[2]' value = '$val' required>";
//echo form_input($data[2], $user_information[0]['user_lname']); ?>
<br><br>
<h5>Gender:</h5>
Male
<?php
if($user_information[0]['user_gender']=='Male'){ //Checks if gender value is equal to Male
echo form_radio($data[3], 'Male', 'TRUE'); } //If yes, check button

else {
echo form_radio($data[3], 'Male'); } //Else, just display button?> 

Female
<?php
if($user_information[0]['user_gender']=='Female'){ //Checks if gender value is equal to Female
echo form_radio($data[3], 'Female', 'TRUE'); } //If yes, check button

else {
echo form_radio($data[3], 'Female'); } //Else, just display button ?> 
<br><br>

    
<h5>Username:</h5>
<?php
$value = $user_accountinfo[0]['user_username'];
echo "<input type = 'text' name = '$data[5]' value = '$value' required>";
//echo form_input($data[5], $user_accountinfo[0]['user_username']); ?>


<?php
   $username = $user_accountinfo[0]['user_username'];
   echo br(2).anchor('index.php/users/update_account/loadchangepass/'.$username,'CHANGE PASSWORD'); ?>
<?php echo br(2).form_submit('', 'Save Changes'); ?>
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

