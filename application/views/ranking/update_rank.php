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
            <?php echo"Ranking Management";?> >>
            <?php echo"Update Rank";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>Update Rank
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(95)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	    <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>";?>
            <br>
            <?php
$rank_info = array();
$count = 0;

foreach($rank_data as $row){
    $rank_info[$count++] = array('rank_id'=> $row->rank_id,
                                 'rank_name'=> $row->rank_name,
                                 'degree_id'=> $row->degree_id,
                                 'remarks'=>$row->remarks);
}
?>

<?php echo form_open('index.php/ranking/update_rank/updaterank/'.$rank_info[0]['rank_id']); ?>

<h5>Rank Name: </h5>
<?php
$name = $rank_info[0]['rank_name'];
//echo form_input('rank_name', $rank_info[0]['rank_name']); 
echo "<input type = 'text' name = 'rank_name' value = '$name' required/>"; ?>

<h5><br>Minimum Educational Qualification:</h5>

<?php
    $degree_list = array();
    $count = 0;
    foreach($degree_data as $degree1){
        $degree_list[$count++] = $degree1->degree_desc;
    }
    
    echo form_dropdown('degree', $degree_list, $rank_info[0]['degree_id']-1);

?>
<h5><br>Remarks: </h5>
<?php echo form_textarea('remarks', $rank_info[0]['remarks']);
echo form_hidden('rank_id', $rank_info[0]['rank_id'])?>
<br>
<?php echo form_submit('', 'Save Changes'); ?>
<?php echo form_close(); ?>

<?php echo form_open('index.php/ranking/update_rank/removesubrank'); ?>
<br>
<h4>Subranks: </h4>
<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>
<thead>
<tr>
<th>Subrank No</h5>
<th>Points</h5>
<th class='action'>Action</h5>
</tr>
</thead>

<tbody>
<?php
    foreach($subrank_data as $row){
        echo "<tr>";
        $m = $row->subrank_id;
        echo "<td>".anchor("index.php/rpc/loadupdatesubrank/".$m, $row->subrank_num)."</td>";
        echo "<td>".$row->min_points."-".$row->max_points."</td>";
        echo "<td class='action'>".form_checkbox('options[]', $m)."</td>";
        echo "</tr>";
    }
?>
</tbody>

</table>
<?php echo anchor("index.php/rpc/loadaddsubrank/".$rank_info[0]['rank_id'], 'Add Subrank'); ?>
<?php echo br(2).form_submit('', 'Remove Subrank/s');

echo form_close(); ?>

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

