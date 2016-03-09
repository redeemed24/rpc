<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/style.css'; ?>" />
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/menu.css'; ?>" />
<!-- jQuery -->
<script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js';?>"></script>

<!-- jQuery Form Validate -->
<script type="text/javascript" src="<?php echo base_url().'js/jquery.paginate.js'?>"></script>
	
<!-- JavaScript -->
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
	
        // Paginate table rows
	$('table tbody').paginate({
				status: $('#status'),
				controls: $('#paginate'),
				itemsPerPage: 10
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
            <?php

$count = 0;
$faculty_info = array();

//Stores all the data fetched from the database to a 2D array $faculty_info
foreach($faculty_data as $row){
    $faculty_info[$count++] = array('faculty_name'=> $row['faculty_lname'].", ".$row['faculty_fname']." ".$row['faculty_mname'],
                                     'program'=>$row['program_name'],
                                     'faculty_id' => $row['faculty_id'],
                                     'status' => $row['status']
                                     );
}

//Search User

echo form_open('index.php/faculty/search_faculty/search');
echo "Search: ";
$opt1='';
$opt = 'placeholder="Enter Last Name"';
echo form_input('keywords',$opt1,$opt);
echo form_close();
echo "<br>";

echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
echo "<thead>";
echo "<tr>";
echo "<th class='no'>&nbsp&nbsp"."No"."&nbsp</th>";
echo "<th>&nbsp"."Name"."&nbsp</th>";
echo "<th>&nbsp"."Program"."&nbsp</th>";
echo "</tr>";
echo "<thead>";

echo "<tbody>";
$num = 0;
for($count = 0; $count<count($faculty_data); $count++){
    
    if($faculty_info[$count]['status']==1){//For activated accounts
        echo "<tr>";
        echo "<td>&nbsp&nbsp".++$num."&nbsp</td>";
        $a = $faculty_info[$count]['faculty_id'];
        echo "<td>&nbsp".anchor("index.php/rpc/loadchecklistforfaculty/".$a, $faculty_info[$count]['faculty_name'], array('faculty_id'=>$a))."</td>";
        echo "<td>&nbsp&nbsp".$faculty_info[$count]['program']."</td>";
    }  
    echo "</tr>";
}
echo "<tbody>";
echo "</table>";

?>
         <br><br>
   <div id="paginate"></div>      
   <div id="status"></div><br> 
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD PROJECT</div>
      </div>

</div>
   
   
</body>
</html>



