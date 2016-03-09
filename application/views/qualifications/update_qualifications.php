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
            <?php echo"Qualification Management";?> >>
            <?php echo"Veiw Qualification";?> >>>
            <?php echo"Update Qualification";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
         <div id="head"><p>Update Qualification
	  <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(80)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	  <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>";?>
         <br>
        
            <?php
$count = 0;
$qualification_info = array();
foreach($qualification_data as $row){
        $qualification_info[$count++] = array('qualification_id'=> $row->qualification_id,
                                 'qualification_name'=>$row->qualification_name,
                                 'maxpoints'=>$row->maxpoints,
                                 'maxpercentage'=>$row->maxpercentage);
}

        echo form_open('index.php/qualification/update_qualification/updatequalification'); 
        echo form_hidden('qualification_id',$qualification_info[0]['qualification_id']);
        
        echo "<h5>Qualification Name: </h5>";
        $name = $qualification_info[0]['qualification_name'];
	//echo form_input('qualification_name',$qualification_info[0]['qualification_name'])."</br>";
        echo "<input type = 'text' name = 'qualification_name' value = '$name' required/>";
	
	
	echo "<h5>Maximum Points: </h5>";
	$maxpoints = $qualification_info[0]['maxpoints'];
        //echo form_input('maxpoints',$qualification_info[0]['maxpoints'])."</br>";
        echo "<input type = 'text' name = 'maxpoints' value = '$maxpoints' required/>";
	
	echo "<h5>Overall Percentage: </h5>";
        $maxpercentage = $qualification_info[0]['maxpercentage'];
	//echo form_input('maxpercentage',$qualification_info[0]['maxpercentage'])."</br>";
        echo "<input type = 'text' name = 'maxpercentage' value = '$maxpercentage' required/>";
	echo"&nbsp<br>";
        
	echo form_submit('','Update');
        echo form_close();
        
        echo "<br><br><h4>Items</h4>";
        echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
	echo "<thead>";
	echo "<tr>";
        echo "<th>&nbsp&nbspItem Name</th>";
        echo "<th class='action'>&nbspAction</th>";
        echo "</tr>";
        echo "<thead>";
	
        echo form_open('index.php/qualification/delete_item/deleteitem');
       
        echo "<tbody>";
        foreach($item_data as $row){
              
	      echo "<tr>";
              echo "<td>&nbsp&nbsp".anchor('index.php/rpc/loadupdateitems/'.$row->item_id, $row->item_name)."</td>";
              $m = $row->item_id;
              echo "<td class='action'>".form_checkbox('options[]', $m)."</td>";
              echo "</tr>";
        }
	echo "<tbody>";
        echo "</table>";
        echo"&nbsp<br><br>";
        echo form_submit('', 'Remove Selected Item/s');
        echo form_close();
        
        echo br(2).anchor('index.php/rpc/loadadditem/'.$qualification_info[0]['qualification_id'], 'Add Item').br(1);
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



