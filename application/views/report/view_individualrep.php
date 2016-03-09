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
                alert("The Database is Succesfully Backed up!");
            });
	
        $("tr:even").css("background-color","#FFAFE1");
        // Paginate table rows
	$('table tbody').paginate({
				status: $('#status'),
				controls: $('#paginate'),
				itemsPerPage: 5
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
            <?php echo"Data Management";?> >>
            <?php echo"Generate Reports";?>
            </div>
         </div>
        
        
        <div id="right">
         <div class="content">
            <div id="head"><p>Individual Summary Form
	     <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(73)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
            <br>
            <div class="tle">UNIVERSITY OF THE IMMACULATE CONCEPTION</br>
<span class="address">Fr. Selga St., and Bonifacio St
8000 Davao City, Philippines</span></br></br>
<b>RANK AND PROMOTION SUMMARY FORM</b></div>

<?php

$count=1;
$sy = array();
foreach($school_year as $row){
    $sy[$count++]=$row->SY_desc;
}

if($individual_data==NULL){
    foreach($faculty_data as $row){
    echo form_open('index.php/report/searchreport/retrieverecord/'.$row->faculty_id);
    echo br(1)."<b>Name: </b>".$row->faculty_lname.", ".$row->faculty_fname." ", $row->faculty_mname.br(1);
    echo "<b>School Year: </b>".form_dropdown('SY', $sy).br(1).form_submit('', 'Retrive Record').br(3);
    echo form_close();
    echo "No results found.";
    }    
}

else{
echo form_open('index.php/report/searchreport/retrieverecord/'.$individual_data[0]['faculty_id']);
$facid;
$syid;
foreach($individual_data as $row){
    echo br(1)."<b>Name: </b>".$individual_data[0]['faculty_lname'].", ".$individual_data[0]['faculty_fname']." ".$individual_data[0]['faculty_mname'];
    echo "&nbsp&nbsp&nbsp<b>Program: </b>".$individual_data[0]['program_name'].br(1);
    
    $facid = $individual_data[0]['faculty_id'];
    $syid= $individual_data[0]['SY_id'];
    
    echo "<b>Previous Rank: </b>".$individual_data[0]['previous_rank']." ".$individual_data[0]['previous'];
    if($this->session->userdata('userlevel_id')==1){
    echo "&nbsp&nbsp <b>School Year: </b>".form_dropdown('SY', $sy, $individual_data[0]['SY_id']).form_submit('', 'Retrive Record').br(3);
    }
    
    echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px''>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='areas'>&nbsp&nbspSpecific Areas</th>";
    echo "<th class='max'>Maximum Points</th>";
    echo "<th class='prevpoints'>Points Earned for Current Year</th>";
    echo "<th class='percent'>Points Percentage</th>";
    echo "</tr>";
    echo "<thead>";
    
   echo "<tbody>";
    foreach($record_data as $samp){
      echo "<tr>";
      echo "<td>&nbsp&nbsp".$samp->qualification_name."</td>";
      echo "<td>&nbsp&nbsp".$samp->maxpoints."</td>";
      echo "<td>&nbsp&nbsp".$samp->points_earned."</td>";
      echo "<td>&nbsp&nbsp".$samp->points_percent."</td>";
      echo "</tr>";
    }
    echo "<tbody>";
    echo "</table>".br(1);
    
    echo "&nbsp".br(1);
    echo "<div id='paginate'></div>";
    echo "<div id='status'></div>";  
    
    echo "&nbsp".br(2)."<span class='record'>TOTAL POINTS EARNED FROM CURRENT RANKING:</span>&nbsp"."<b>".$individual_data[0]['currentpoints']."</b>";
    echo br(1)."<span class='record'>POINTS EARNED FROM PREVIOUS RANKING: </span>"."<b>".$individual_data[0]['prevpoints']."</b>";
    echo br(1)."<span class='record'>TOTAL: </span>"."<b>".$individual_data[0]['total_points']."</b>";
    echo br(1)."<span class='record'>EQUIVALENT RANK: </span>"."<b>".$individual_data[0]['current_rank']." ".$individual_data[0]['current']."</b>";
    
echo form_close();

   echo br(1)."Remarks: ";
   echo form_open('index.php/report/notes/update_remarks/'.$individual_data[0]['report_id']);
   echo form_textarea('remarks', $individual_data[0]['remarks']).br(1);
   echo form_submit('', 'Save Changes');
   echo form_close();   
   echo "<span class='record'>EVALUATED BY: </span>"."<b>".$individual_data[0]['user_fname']." ".$individual_data[0]['user_lname']."</b>";}
   
   if($updated_data!=NULL){
      foreach($updated_data as $row){
	 echo br(1).nbs(2)."<span class='record'>UPDATED BY: </span>"."<b>".$row->user_fname." ".$row->user_lname."</b>";   
      }
   }
   if( $this->session->userdata('userlevel_id')==1){
   echo br(1)."<div class='pos'>".anchor('index.php/rpc/loadprintindividualreports/'.$facid.'/'.$syid,"<p class='print'></p>")."</div>";
   }
   else{
   echo br(2)."<div class='pos'>".anchor('index.php/rpc/loadprintindividualreports/'.$facid.'/'.$syid,"<p class='print'></p>")."</div>"; 
   }
   
}
?>
</div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
      </div>

</div>
   
   
</body>
</html>
