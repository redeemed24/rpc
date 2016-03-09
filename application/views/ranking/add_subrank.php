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
                  <div class="logout"><?php echo anchor('Rpc/loadlogin','[Logout]');?> | <?php echo anchor('Rpc/index','[Account Settings]');?></div>

            <div id="modules" class="menu_list">
            <?php include '../application/views/menu_condition.php';?>
            </div>
         </div>
         <div id="breadcrumpic">
            <div class="breadcrum">
            <?php echo anchor('Rpc/index','Main');?> >
            <?php echo "Ranking Management";?> >>
            <?php echo "Update Rank";?> >>>
            <?php echo "Add Subrank";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
         <div id="head"><p>Add Subrank
	 <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(94)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
         <br>
	 
	 
	 <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>"; ?>
<?php

$count = 0;
$rank_info = array();
foreach($rank_data as $row){
    $rank_info[$count++] = array('rank_id' => $row->rank_id,
                                 'rank_name' => $row->rank_name);
}

$subrank = array('subrank_num', 'min_points', 'max_points');
?>

<?php echo form_open('index.php/ranking/add_subrank/addsubrank/'.$rank_info[0]['rank_id']); ?>

<?php echo "Rank Name: "."<b>".$rank_info[0]['rank_name']."</b>"; ?>

<?php //echo form_input($subrank[0]);
   echo form_hidden($subrank[0][1]); ?>
</br>

<h5> Minimum Points </h5>
<?php //echo form_input($subrank[1]); ?>
<input type = 'text' name = 'min_points' required/>
</br>

<h5> Maximum Points </h5>
<?php //echo form_input($subrank[2]); ?>
<input type = 'text' name = 'max_points' required/>
</br></br>

<?php echo form_submit('', 'Add Subrank'); ?>
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

