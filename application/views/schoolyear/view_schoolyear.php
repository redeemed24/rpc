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
				itemsPerPage: 15
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
	    <?php echo"Academic Year Management";?> >>
	    <?php echo"Set Academic Year";?>
            </div>
         </div>
        
        
        <div id="right">
         <div class="content">
	    <div id="head"><p>Set School Year
            <?php
	    foreach($schoolyear as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(90)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
            </p></div>
           <br>
	    
            <table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>
    <thead>
    <tr>
    <th class="no">No</th>
    <th>&nbsp&nbspAcademic Year</th>
    <th class="action">Action</th>
    </tr>
    </thead>
    <tbody>
<?php
$count =1;

$id;
foreach($current_schoolyear as $row){
    $id = $row->SY_id;
}

foreach($schoolyear_data as $row){
    echo "<tr>";
    echo "<td>&nbsp&nbsp".$count++."</td>";
    
    
     echo "<td>&nbsp&nbsp".$row->SY_desc."</td>";  
    
    
    echo "<td>";
    
        if($row->status==0 && $row->SY_id==$id+1){
            echo anchor('index.php/schoolyear/set_schoolyear/set/'.$id."/".$row->SY_id,'&nbsp&nbsp<b>Set</b>');
        }
        
        else if($row->status==1){
            echo "&nbsp&nbspCurrent";
        }
        
    echo "</td>";
    echo "</tr>";
}

?>
</tbody>    
</table>
   <?php echo anchor('index.php/schoolyear/add_schoolyear/addschoolyear', 'ADD NEW ACADEMIC YEAR'); ?>
<br><br>
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
