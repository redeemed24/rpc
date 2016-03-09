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
				itemsPerPage: 1
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
            <?php echo "Qualification Management";?> >>
            <?php echo "View Qualification";?>   
            
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>View Qualification
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(85)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
            <br>
            <?php echo form_open('index.php/qualification/search_qualification/searchqualification');
                  echo "Search: ";
                  $opt1='';
                  $opt = 'placeholder="Enter Qualification Name"';
                  echo form_input('keywords',$opt1,$opt);
            echo form_close();

//Activate or deactivate accounts
//Displays all users in tabular format

if($qualification_data == NULL){
    echo 'No results found.';
}


else{
echo "<br>";
echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
echo form_open('index.php/qualification/delete_item/deletequalification');
echo "<thead>";
echo "<th class='qual'>&nbspQualification<th class='items'>&nbspItems<th class='max'>Maximum Points<th class='percent'>Overall Percentage<th class='action'>Action</th>";
echo "</thead>";

echo "<tbody>";
foreach($qualification_data as $qualification1){
        echo "<tr>";
        echo "<td>&nbsp".anchor('index.php/rpc/loadupdatequalification/'.$qualification1->qualification_id, $qualification1->qualification_name)."</td>";
        echo "<td>";
foreach($item_data as $item1){
    if($item1->qualification_id == $qualification1->qualification_id){
    echo "* ".$item1->item_name;
    echo "<br>";
    }
    }
    
    echo "</td>";
        echo "<td class='max'>". $qualification1->maxpoints."</td>";
        echo "<td class='percent'>". $qualification1->maxpercentage."</td>";
        echo "<td class='action'>". form_checkbox('options[]', $qualification1->qualification_id); 
        echo "</tr>";
    
}
echo "</tbody>";
echo "</table>";
echo "&nbsp<br><br>";
echo br(1).form_submit('', 'Remove Selected Qualification/s').br(1);
echo form_close();
echo br(1)."<div class='pos'>".anchor('index.php/rpc/loadprintqualifications',"<p class='print'></p>")."</div>".br(1);
}
?>
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



