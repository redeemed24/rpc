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
            <?php echo"Data Management";?> >>
            <?php echo"Generate Reports";?>
            </div>
         </div>
        
        
        <div id="right">
         <div class="content">
            <div id="head"><p>Generate Reports
            <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(84)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
            </p></div>
            <br>
            <?php

echo form_open('index.php/report/searchreport/readreport');

$SY_list = array();
$count = 0;

foreach($school_year as $row){
    $SY_list[$count++] = $row->SY_desc;
}

$program_list = array();
$program_list[0] = "All Records";
$count = 1;

foreach($program_data as $row){
    $program_list[$count++] = $row->program_name;
}
echo br(1)."Program: ".form_dropdown('program', $program_list)."<br><br>School Year: ".form_dropdown('SY', $SY_list).br(2);
echo "Name: ";
        $opt1='';
        $opt = 'placeholder="Enter Last/First Name"';
echo form_input('keywords',$opt1,$opt);
echo form_submit('', 'Search');
echo form_close();

if($report_data != NULL){
    
    //print_r($report_data);
    
    echo "<br><table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='no'>No</th>";
    echo "<th class='program1'>Program</th>";
    echo "<th class='name'>Name</th>";
    echo "<th class='total'>Total</th>";
    echo "<th class='rank'>Previous Points</th>";
    echo "<th class='rank'>Previous Rank</th>";
    echo "<th class='rank'>Current Points</th>";
    echo "<th class='rank'>Current Rank</th>";
    echo "<th class='pegged'>Pegged</th>";
    echo "<th class='remarks'>Remarks</th>";
    echo "</tr>";
    echo "<thead>";
    echo "<tbody>";
    $count1 =0;
    $count = 0;
    foreach($report_data as $row){
        echo "<tr>";
        echo "<td class='no'>".++$count1."</td>";
        echo "<td class='program1'>".$report_data[$count]['program_name']."</td>";
        $name = $report_data[$count]['faculty_lname'].", ".$report_data[$count]['faculty_fname']." ".$report_data[$count]['faculty_mname'];
        
	
	if($report_data[$count]['previous']==0){
	 $report_data[$count]['previous'] = "";
	}
	
	if($report_data[$count]['pegg']==0){
	 $report_data[$count]['pegg']= "";
	}
	
	
        echo "<td class='name'>".anchor("index.php/report/searchreport/individual/".$report_data[$count]['faculty_id']."/".$report_data[$count]['SY_id'], $name)."</td>";
        echo "<td class='rank'>".$report_data[$count]['currentpoints']."</td>";
        echo "<td class='rank'>".$report_data[$count]['prevpoints']."</td>";
        echo "<td class='rank'>".$report_data[$count]['previous_rank']." ".$report_data[$count]['previous']."</td>";
        echo "<td class='total'>".$report_data[$count]['total_points']."</td>";
        echo "<td class='rank'>".$report_data[$count]['current_rank']." ".$report_data[$count]['current']."</td>";
        echo "<td class='pegged'>".$report_data[$count]['pegged']." ".$report_data[$count]['pegg']."</td>";
        echo "<td class='remarks'>".$report_data[$count]['remarks']."</td>";
        $count++;
        echo "</tr>";
    }
    echo "<tbody>";
    echo "</table>";
    
    foreach($keywords as $column){
      if($column==0){
	 foreach($records as $row){
	    if($row == 0){
	    $val = 0;
	    }
	    else{
	    $val = 1;
	    }
	 
          if($this->session->userdata('userlevel_id')==1){
               echo "<div class='pos4'>".anchor('index.php/rpc/loadprintallreports/'.$val.'/'.$report_data[0]['program_id'].'/'.$report_data[0]['SY_id'],"<p class='print'></p>")."</div>"; //export to pdf
                
            }
         
         }//end foreach row
    
         }
         
    
   }//end foreach column
   
         
}

?>
   <div id="paginate"></div>      
   <div id="status"></div><br> 
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
      </div>

</div>
   
   
</body>
</html>
