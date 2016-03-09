<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/style.css'; ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/menu.css'; ?>" />
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url().'js/jquery.paginate.js'?>"></script>

<script type="text/javascript">
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
	
        $("tr:even").css("background-color","#FFAFE1");
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
            <?php echo anchor('Rpc/index','Main');?> >
            <?php echo"Faculty Management" ;?> >>
            <?php echo"View Faculty" ;?>
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>View Faculty
	      <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(95)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?></p></div>
            <br>
            <?php

//Search User

echo form_open('index.php/faculty/search_faculty/search');
$program = array();
$program[0] = "All Program";
$count =1;
foreach($program_data as $row){
   $program[$count] = $row->program_name;
   $count++;
}
echo "Program: ".form_dropdown('program', $program).br(2);

echo "Name: ";
$opt1='';
$opt = 'placeholder="Enter Last/First Name"';
echo form_input('keywords',$opt1,$opt);
echo "&nbsp".form_submit('', 'Search');
echo form_close();

if($faculty_data!=NULL){
   
$count = 0;
$faculty_info = array();

//Stores all the data fetched from the database to a 2D array $faculty_info
foreach($faculty_data as $row){
    $faculty_info[$count++] = array('faculty_name'=> $row['faculty_lname'].", ".$row['faculty_fname']." ".$row['faculty_mname'],
                                     'program'=>$row['program_name'],
                                     'faculty_id' => $row['faculty_id'],
                                     'status' => $row['status'],
				     'degree_id' => $row['degree_id']
                                     );
}


echo "<br>";
echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
echo "<thead>";
echo "<tr>";
echo "<th class='no'>&nbsp&nbsp"."No"."&nbsp</th>";
echo "<th>&nbsp"."Name"."&nbsp</th>";
echo "<th>&nbsp"."Program"."&nbsp</th>";
echo "<th class='status'>&nbsp"."Record Status"."&nbsp</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
for($count = 0; $count<count($faculty_data); $count++){
    echo "<tr>";
    echo "<td>&nbsp&nbsp".($count+1)."&nbsp</td>";
    $a = $faculty_info[$count]['faculty_id'];
    echo "<td>&nbsp".anchor("index.php/rpc/loadupdatefaculty/".$a, $faculty_info[$count]['faculty_name'], array('faculty_id'=>$a))."&nbsp</td>";
    echo "<td>&nbsp".$faculty_info[$count]['program']."&nbsp</td>";
    
    if($faculty_info[$count]['status']==1){//For activated accounts
        $num = 0;
        echo "<td>&nbsp".anchor("index.php/faculty/update_faculty/updatestatus/".$num."/".$a."/".$faculty_info[$count]['degree_id'], "Deactivate")."&nbsp</td>";
    }

    else if($faculty_info[$count]['status']==0){// For deactivated accounts
        $num = 1;
        echo "<td>&nbsp".anchor("index.php/faculty/update_faculty/updatestatus/".$num."/".$a."/".$faculty_info[$count]['degree_id'], "Activate")."&nbsp</td>";
    }
    
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
}
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



