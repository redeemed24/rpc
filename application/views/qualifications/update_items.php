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
            <?php echo anchor('Rpc/index','Main');?>
            </div>
         </div>
	 
        <div id="right">
         <div class="content">
	     <div id="head"><p>Update Item
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(95)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	     </br>
            <?php

echo form_open('index.php/qualification/update_item/updateitem');

$item_info = array();
$count = 0;
foreach($item_data as $item1){
        $item_info[$count++] = array('quali_id'=>$item1->qualification_id,
                                    'quali_name'=>$item1->item_name,
                                    'item_id'=>$item1->item_id);
}

echo "Qualification: ";
$quali_info = array();
$count = 0;
$default;
foreach($qualification_data as $qualification1){
        $quali_info[$count++] = $qualification1->qualification_name;
	if($qualification1->qualification_id == $item_info[0]['quali_id']){
        $default = $count;
	}
}

echo form_dropdown('qualification', $quali_info, $default-1);
echo "</br>Name: ";
//echo form_input('item_name', $item_info[0]['quali_name']);
$name = $item_info[0]['quali_name'];
echo "<input type = 'text' name = 'item_name' value = '$name' required/>";
echo form_hidden('item_id', $item_info[0]['item_id']);
echo form_submit('','Update');
echo form_close();
?>
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD PROJECT</div>
      </div>

</div>
   
   
</body>
</html>

