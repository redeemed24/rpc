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
         <div class="logout"><?php echo anchor('Rpc/loadlogout','[Logout]');?> | <?php echo anchor('Rpc/loadaccountsettings/'.$this->session->userdata('username'),'[Account Settings]');?></div>

            <div id="modules" class="menu_list">
            <?php include '../application/views/menu_condition.php';?>
            </div>
         </div>
         <div id="breadcrumpic">
            <div class="breadcrum">
            <?php echo anchor('Rpc/index','Main');?> >
            <?php echo"Ranking Management";?> >>
            <?php echo"Add Rank";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>Add Rank
	      <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(100)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	     <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>";?>
            <br>
            <?php echo form_open('index.php/ranking/add_rank/addrank'); ?>

<h5>Rank Name: </h5>
<?php   $opt1='';
        $opt = 'placeholder="Enter Rank Name"';
        echo "<input type = 'text' name = 'rank_name' $opt required/>";
	//form_input('rank_name'); ?>
<br><br>
<h5>Minimum Educational Qualification:</h5>
<?php
    $degree_list = array();
    $count = 0;
    foreach($degree_data as $degree1){
        $degree_list[$count++] = $degree1->degree_desc;
    }
    
    echo form_dropdown('degree', $degree_list);

?>
<br><br>
<h5>Remarks: </h5>
<?php echo form_textarea('remarks'); ?>
<br><br>
<?php echo form_submit('', 'Add Rank'); ?>
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





