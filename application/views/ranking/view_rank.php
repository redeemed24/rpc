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
            <?php echo"Ranking Management" ;?> >>
            <?php echo"View Rank";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
            <div id="head"><p>View Rank
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(99)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>

<br>            
<?php
$count = 0;

$rank_info = array();
$subrank_info = array();

foreach($rank_data as $row){
    $rank_info[$count++] = array('rank_id'=>$row['rank_id'],
                                 'rank_name'=>$row['rank_name'],
                                 'remarks'=>$row['remarks'],
                                 'degree'=>$row['degree_desc']);
}

$count = 0;
foreach($subrank_data as $row){
    $subrank_info[$count++] = array('rank_id'=>$row['rank_id'],
                                    'subrank_id'=> $row['subrank_id'],
                                    'subrank_num'=>$row['subrank_num'],
                                    'min_points'=>$row['min_points'],
                                    'max_points'=>$row['max_points']);
}

//Search Rank

echo form_open('index.php/ranking/search_rank/searchrank');
echo "Search: ";
        $opt1='';
        $opt = 'placeholder="Enter Rank Name"';
        echo form_input('keywords',$opt1,$opt);
echo form_close();

//Activate or deactivate accounts
//Displays all users in tabular format

if($rank_data == NULL){
    echo 'No results found.';
}

else{
echo"<br>";    
echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
echo "<thead>";
echo "<tr>";
echo "<th class='no'>"."&nbsp&nbspNo&nbsp"."</th>";
echo "<th>&nbsp"."Faculty Rank"."</th>";
echo "<th class='subrank'>&nbsp"."Subrank/<br>Steps"."</th>";
echo "<th class='min'>&nbsp"."Points"."</th>";
echo "<th class='minimum'>&nbsp"."Minimum Educational Qualification"."</th>";
echo "<th class='remarks'>&nbsp"."Prevailing Criteria"."</th>";
echo "<th class='action'>"."Action"."</th>";
echo "</tr>";
echo "</thead>";
echo form_open('index.php/ranking/update_rank/removerank');
echo "<tbody>";
for($count = 0; $count<count($rank_data); $count++){
    echo "<tr>";
    $a = $rank_info[$count]['rank_id'];
    echo "<td>&nbsp&nbsp".($count+1)."</td>";
    echo "<td>".anchor("index.php/rpc/loadupdaterank/".$a, $rank_info[$count]['rank_name'], $info['infos'] = array('rank_name'=>$a))."</td>";
    
    echo "<td>";
        for($counta=0; $counta<count($subrank_data); $counta++){
            $m = $subrank_info[$counta]['subrank_id'];
            if($rank_info[$count]['rank_id']==$subrank_info[$counta]['rank_id']){
                echo $subrank_info[$counta]['subrank_num']."</br>";
            }
        }
    
    echo "</td>";
    
    echo "<td class='points'>";
    for($counta=0; $counta<count($subrank_data); $counta++){
            if($rank_info[$count]['rank_id']==$subrank_info[$counta]['rank_id']){
                echo $subrank_info[$counta]['min_points']."-".$subrank_info[$counta]['max_points']."</br>";
            }
        }
    echo "</td>";
    
    echo "<td class='degree'>".$rank_info[$count]['degree']."</td>";
    echo "<td>&nbsp&nbsp".$rank_info[$count]['remarks']."</td>";
    echo "<td class='action'> &nbsp&nbsp".form_checkbox('options[]', $a)."</td>";
    echo "</tr>";
}
echo "<tbody>";
echo "</table>";



echo br(1).form_submit('','Remove Selected Rank/s').br(1);
echo form_close();

echo br(1)."<div class='pos'>".anchor('index.php/rpc/loadprintranks/',"<p class='print'></p>")."</div>".br(1);

}

?>

   <div id='paginate'></div>      
   <div id='status'></div>
         </div>   
         
      </div>
   </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
      </div>

</div>
   
   
</body>
</html>











