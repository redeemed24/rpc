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
	
	$("tr:even").css("background-color","#FFAFE1");
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
	    <?php echo"Program Management";?> >>
	    <?php echo"View Program";?> 
            </div>
         </div>
        
        
        <div id="right">
         <div class="content">
	 <div id="head"><p>View Program
          <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(93)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
            </p></div>
         <br>
	 
    <table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>
    <tr>
    <th class="no">No</th>
    <th>&nbsp&nbspProgram Name</th>
    <th class="program">&nbsp&nbspCommittee-In-Charge</th>
    </tr>
    
    <?php
    
    //print_r($program_data);
    $count = 0;
    $count1 =0;
    
    echo form_open('index.php/programs/delete_program/deleteprogram');
    foreach($program_data as $row){
        echo "<tr>";
        echo "<td class='no'>".++$count1."</td>";
        echo "<td>&nbsp&nbsp".anchor("index.php/rpc/loadupdateprogram/".$program_data[$count]['program_id'],$program_data[$count]['program_name'])."</td>";
        echo "<td>&nbsp&nbsp".$program_data[$count]['user_fname']."</td>";
        //echo "<td class='action'>".form_checkbox('options[]', $program_data[$count]['program_id']);
        echo "</tr>";
            $count++;
    }
    ?>
    
</table>

<?php  //echo "&nbsp".br(1).form_submit('', 'Remove Selected Program/s');
       echo form_close();
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
