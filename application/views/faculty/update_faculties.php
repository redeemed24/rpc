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
            <?php echo"Faculty Management";?> >>
            <?php echo"View Faculty";?> >>>
            <?php echo"Update Faculty";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>Update Faculty  <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(90)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?></p></div>
            <br>
            <?php

$faculty_info = array(); //Stores all the information of a faculty
$count = 0;

foreach($faculty_data as $row){
    $faculty_info[$count++] = array('faculty_id' => $row->faculty_id,
                                    'faculty_fname' => $row->faculty_fname,
                                    'faculty_mname' => $row->faculty_mname,
                                    'faculty_lname' => $row->faculty_lname,
                                    'faculty_gender' => $row->faculty_gender,
                                    'program_id' => $row->program_id,
                                    'degree_id' => $row->degree_id,
                                    'status' => $row->status);
}
?>

<?php echo form_open('index.php/faculty/update_faculty/updatefaculty/'.$faculty_info[0]['faculty_id']);
$data = array( 'faculty_fname','faculty_mname',
                    'faculty_lname','faculty_gender'); // Stores the data in each texbox
?>

<h5> First Name: </h5>
<?php
$value = $faculty_info[0]['faculty_fname'];
echo "<input type = 'text' name = '$data[0]' value = '$value' required>";
//echo form_input($data[0], $faculty_info[0]['faculty_fname']); ?>

<h5> Middle Name: </h5>
<?php
$value = $faculty_info[0]['faculty_mname'];
echo "<input type = 'text' name = '$data[1]' value = '$value' required>";
//echo form_input($data[1], $faculty_info[0]['faculty_mname']); ?>

<h5> Last Name: </h5>
<?php
$value = $faculty_info[0]['faculty_lname'];
echo "<input type = 'text' name = '$data[2]' value = '$value' required>";
//echo form_input($data[2], $faculty_info[0]['faculty_lname']); ?>
<br><br>
<h5>Gender:</h5>
Male
<?php
if($faculty_info[0]['faculty_gender']=='Male'){ //Checks if gender value is equal to Male
echo form_radio($data[3], 'Male', 'TRUE'); } //If yes, check button

else {
echo form_radio($data[3], 'Male'); } //Else, just display button?> 

Female
<?php
if($faculty_info[0]['faculty_gender']=='Female'){ //Checks if gender value is equal to Female
echo form_radio($data[3], 'Female', 'TRUE'); } //If yes, check button

else {
echo form_radio($data[3], 'Female'); } //Else, just display button ?> 
<br><br>
<h5>Program:</h5>

<?php
   $program_list = array();
   $count=0;
   foreach($program_data as $program1){
        $program_list [$count++] =$program1->program_name;
      }
      
echo form_dropdown('program', $program_list, $faculty_info[0]['program_id']-1);

?>
<br><br>
<h5>Educational Qualification:</h5>
<?php
    $degree_list = array();
    $count = 0;
    foreach($degree_data as $degree1){
        $degree_list[$count++] = $degree1->degree_desc;
    }
    
    echo form_dropdown('degree', $degree_list, $faculty_info[0]['degree_id']-1);
    echo form_hidden('old_degree', $faculty_info[0]['degree_id']-1);
?>
<br><br>
<h5>Record Status:</h5>

<?php
   $userstatus = array('Deactivated', 'Activated');
   echo form_dropdown('status', $userstatus, $faculty_info[0]['status']);
   echo form_hidden('old_status', $faculty_info[0]['status']);
?>
<br><br>
<?php echo form_submit('', 'Save Changes'); ?>
<?php echo form_close(); ?>
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD PROJECT</div>
      </div>

</div>
   
   
</body>
</html>



