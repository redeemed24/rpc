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
            <?php echo "Update Subrank";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
        <div id="head"><p>Update Subrank
	<?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(90)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	 <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>"; ?>
         <br>

<?php

$count = 0;
$subrank_info = array();
foreach($subrank_data as $row){
    $subrank_info[$count++] = array('subrank_id' => $row->subrank_id,
                                 'rank_id' => $row->rank_id,
                                 'subrank_num'=> $row->subrank_num,
                                 'min_points'=> $row->min_points,
                                 'max_points'=> $row->max_points);
}

$subrank = array('subrank_num', 'min_points', 'max_points');
?>

<?php echo form_open('index.php/ranking/update_subrank/updatesubrank/'.$subrank_info[0]['subrank_id']); ?>

<h5>Faculty Rank:
<?php

$rank_info = array();
$count = 0;

$default;
foreach($rank_data as $row){
    $rank_info[$count++] = $row['rank_name'];
    if($row['rank_id'] == $subrank_info[0]['rank_id']){
    $default = $count;
    }
}

//print_r($rank_info);
echo form_dropdown('rank', $rank_info, $default-1);
?> </h5>
	 </br>
<h5>Subrank Number: </h5>
<?php //echo form_input($subrank[0], $subrank_info[0]['subrank_num']);
$num = $subrank_info[0]['subrank_num'];
   echo $num;
   echo form_hidden('subrank_num', 1); ?> </br>

<h5> Minimum Points </h5>
<?php //echo form_input($subrank[1], $subrank_info[0]['min_points']);
$min =  $subrank_info[0]['min_points'];
 echo "<input type = 'text' name = 'min_points' value = '$min' required/>";
 echo form_hidden('old_min', $min);
?> </br>

<h5> Maximum Points </h5>
<?php //echo form_input($subrank[2], $subrank_info[0]['max_points']);
$max = $subrank_info[0]['max_points'];
echo "<input type = 'text' name = 'max_points' value = '$max' required/>";
echo form_hidden('old_max', $max);
echo form_hidden('subrank_id', $subrank_info[0]['subrank_id']);
?> </br>

<?php echo form_submit('', 'Submit'); ?>
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


