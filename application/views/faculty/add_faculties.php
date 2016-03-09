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
            <?php echo anchor('','Main');?> >
            <?php echo anchor('','User Management</a>');?> >>
            <?php echo anchor('','Add Faculty</a>');?> 
            </div>
         </div>
        <div id="right">
         
          <?php echo form_open('faculty/add_faculty/addfaculty');
 $data = array( 'faculty_fname','faculty_mname',
                    'faculty_lname','faculty_gender','program_id', 'degree_id'); ?>
          <div class="content">
           
         <div id="head"><p>Add Faculty
	   <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(97)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	 </p></div>
         <br>   
          <h5> First Name: </h5>
<?php $opt = 'placeholder="Enter First Name"';
    echo "<input type = 'text' name = '$data[0]' required>";
    //echo form_input($data[0],'',$opt); ?>
<br>
<h5> Middle Name: </h5>
<?php $opt = 'placeholder="Enter Middle Name"';
echo "<input type = 'text' name = '$data[1]' required>";
//echo form_input($data[1],'',$opt); ?>
<br>
<h5> Last Name: </h5>
<?php $opt = 'placeholder="Enter Last Name"';
echo "<input type = 'text' name = '$data[2]' required>";
//echo form_input($data[2],'',$opt); ?>
<br><br>
<h5>Gender:</h5>
Male
<?php echo form_radio($data[3],'Male'); ?>

Female
<?php echo form_radio($data[3],'Female'); ?>
<br><br>
<h5>Program:</h5>

<?php
   $program_list = array();
   $count=0;
   foreach($program_data as $program1){
        $program_list [$count++] =$program1->program_name;
      }
      
echo form_dropdown('program', $program_list);

?>
<br><br>
<h5>Educational Qualification:</h5>
<?php
    $degree_list = array();
    $count = 0;
    foreach($degree_data as $degree1){
        $degree_list[$count++] = $degree1->degree_desc;
    }
    
    echo form_dropdown('degree', $degree_list);
?>
<br><br>
<h5>Record Status:</h5>
            <?php
               $userstatus = array('Activate', 'Deactivate');
               echo form_dropdown('status', $userstatus);
            ?>
         <br><br>
<?php echo form_submit('', 'Add Faculty');

      echo form_reset('', 'Clear'); ?>
<?php echo form_close(); ?>          
         </div>
      </div>
   </div>
      
       <div id="footer">
        <div class="foot">Copyright Team Fairytale 2012</div>
         </div>
</div>
   
   
</body>
</html>






