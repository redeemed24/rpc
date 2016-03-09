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
            <?php echo"View Faculty Record";?> >>>
            <?php echo"Update Faculty Record";?>
            
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>Update Faculty Record
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(76)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
            <br>
    
  <?php
    
    echo form_open('index.php/checklist/searchpoints/points');
    
    $facid;
    foreach($faculty_data as $row){
        echo "<b>Name: </b>".$row->faculty_lname.", ".$row->faculty_fname." ".$row->faculty_mname." "; //Display Faculty Name 
        echo form_hidden('faculty_id', $row->faculty_id);
        $facid = $row->faculty_id;
    }
            
    $count =0;
    $sy_info = array();
    foreach($school_year as $row){
        $sy_info[$count++] = $row->SY_desc;
    }
    
    if($record_data==NULL){
        echo form_dropdown('school_year', $sy_info);
        echo form_submit('', 'Submit');
        echo form_close();
         echo "</br>No results found.";
    }
    
    else{ //Has a record for the school year
        
    foreach($record_data as $row){
        $school_year [0]= $row->sy_id;
    }
    
    if($this->session->userdata('userlevel_id')==1){
    echo form_dropdown('school_year', $sy_info, $school_year[0]-1);
    echo form_submit('', 'Submit');
    }
    
    else{
      $val =  $school_year[0]-1;
      echo "School Year: ".$sy_info[$val].br(1);
    }
    
    $prev_rank;
    foreach($previous_rank as $rank){
        echo br(1)."<b>Previous Rank: </b>".$rank->rank_name." ".$rank->subrank_num;
    }
    echo form_close();
    
    echo "</br>".form_open('index.php/checklist/updatepoints/points');
    
    $sy; //variable to check school year
    echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>"; 
    echo "<tbody>";
    foreach($totalrecord_data as $total){
    //foreach($qualification_data as $qualification1){
    echo "<tr>";
    echo "<th id='temp'><b>&nbsp&nbsp".$total->qualification_name." (".$total->maxpoints." maximum points)"."</b></th>";
    echo "<th id='temp'><b>&nbsp&nbsp"."(".$total->maxpercentage." percentage)"."</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<th>&nbsp&nbspItems</th>";
    echo "<th class='earn'>Points Earned</th>";
    echo "</tr>";
    $sy = $total->SY_id;
    
    foreach($record_data as $record){
    if($record->qualification_id == $total->qualification_id){
    echo "<tr>";
    echo "<td>&nbsp&nbsp".$record->item_name."</td>";
    echo "<td><input type = 'text' name ='$record->checklist_id' value = '$record->points'required/></td>";
    echo form_hidden($record->checklist_id."checklist_id", $record->checklist_id);
    echo "</tr>";
    
    }//end if
    }//end  foreach($record_data as $record)
    echo"<tr>";
    echo "<th>&nbsp&nbspTotal: ". $total->points_earned."</th>";
    echo "<th>&nbsp&nbspAverage: ".$total->points_percent."</th>";
    echo"</tr>";
    echo form_hidden($total->record_id."record_id", $total->record_id);
    
    }// end foreach($qualification_data as $qualification1)	
    echo "</tbody>";
    echo "</table>";
    echo form_hidden('sy_id', $total->SY_id);
    echo form_hidden('faculty_id', $total->faculty_id); 
    
   foreach($current_schoolyear as $schoolyear){
      if($sy==$schoolyear->SY_id && $this->session->userdata('userlevel_id')!=1){
	 echo br(1).form_submit('','Update Changes');  
      }
   }
     
    //echo form_submit('','Update Changes');

if($this->session->userdata('userlevel_id')!=1){
    echo br(1)."<div class='pos'>".anchor('index.php/rpc/loadprintrecords/'.$facid.'/'.$total->SY_id.'/',"<p class='print'></p>")."</div>".br(1);  
    
    }
    
    else{
	 echo br(1)."<div class='pos3'>".anchor('index.php/rpc/loadprintrecords/'.$facid.'/'.$total->SY_id.'/',"<p class='print'></p>")."</div>".br(1);
	
    }
echo form_close();   
    }// end else
?>
   <br>
   <div id="paginate"></div>      
   <div id="status"></div>
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD PROJECT</div>
      </div>

</div>
   
   
</body>
</html>