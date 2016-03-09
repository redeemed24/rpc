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
				itemsPerPage: 20
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
            <?php echo"Fill Up Checklist";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>Fill Up Checklist
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(90)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
           <?php
//echo $this->pagination->create_links();

$count = 0;
$faculty_info = array();

//Stores all the data fetched from the database to a 2D array $faculty_info
foreach($faculty_data as $row){
    $faculty_info[$count++] = array('faculty_name'=> $row->faculty_lname.", ".$row->faculty_fname." ".$row->faculty_mname,
                                     'faculty_id' => $row->faculty_id,
                                     'status' => $row->status
                                     );
}

$count = 0;
$sy_info = array();
//read school year
foreach ($school_year as $row){
    $sy_info[$count++] = array('sy_desc'=>$row->SY_desc, 'sy_id'=>$row->SY_id);
}


for($count = 0; $count<count($faculty_data); $count++){
    if($faculty_info[$count]['status']==1){//For activated accounts
    echo form_open('index.php/checklist/savepoints/points');
    
    echo "<br><b>Name: </b>".$faculty_info[$count]['faculty_name']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; //Display Faculty Name
    echo form_hidden('faculty_id', $faculty_info[0]['faculty_id']);
    echo "<b>School Year: </b>".$sy_info[0]['sy_desc']."<br>"; //Display School Year
    echo "<b class='direction'>Direction: Please fill in encircle or highlights items applicable to you and attach supporting documents. Thank you.</b><br>";
    echo form_hidden('sy_id', $sy_info[0]['sy_id']);
    $count = 0;
    echo br(1);
    echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
    echo "<tbody>";
    foreach($qualification_data as $qualification1){
    echo "<tr>";
    echo "<th id='temp'><b>".$qualification1->qualification_name." (".$qualification1->maxpoints." maximum points)"."</b></th>";
    echo "<th id='temp'></th>";
    echo "</tr>";
    echo "<tr>";
    echo "<th class='items'>&nbsp&nbspItems</th>";
    echo "<th class='earn'>Points Earned</th>";
    echo "</tr>";
    
    foreach($item_data as $item1){
    $count++; //count all number of items
    if($item1->qualification_id == $qualification1->qualification_id){
    echo "<tr>";
    echo "<td>&nbsp&nbsp".$item1->item_name."</td>";
    echo "<td><input type = 'text' name ='$item1->item_id' required/></td>";
    //echo "<td>".form_input($item1->item_id);
    echo form_hidden($item1->item_id."id", $item1->item_id);
    echo "</tr>";}
    }
    
    }
    
    }  
    
}
echo "</tbody>";
echo "</table>";
$item_no = array('count');
    echo form_hidden($item_no[0], $count); //pass number of items for saving in database (model->savepoints.php)
    echo form_submit('','Submit');
    echo form_close();
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



