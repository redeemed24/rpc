<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/style.css'; ?>" />
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/menu.css'; ?>" />
<script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js';?>"></script>
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
	
	$('table tbody').paginate({
				status: $('#status'),
				controls: $('#paginate'),
				itemsPerPage: 3
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
         <div class="welcome">Welcome, &nbsp&nbsp<?php $user = array();echo $this->session->userdata('name').br(1);?>
	 <?php echo $this->session->userdata('userlevel_name');?></div>
         <div class="logout"><?php echo anchor('Rpc/loadlogout','[Logout]');?> | <?php echo anchor('Rpc/loadaccountsettings/'.$this->session->userdata('username'),'[Account Settings]');?></div>

            <div id="modules" class="menu_list">
               <?php include '../application/views/menu_condition.php';?>
            </div>
            
         </div>
         <div id="breadcrumpic">
            <div class="breadcrum">
            <?php echo anchor('Rpc/index','Main');?>
            </div>
         </div>
        
        
        <div id="right">
         <div class="content">
	    <div id="head"><p>Home Page
	    <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(96)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p>
	    </div>
	    <br>
	    <table class="table">
            <thead><h4 class="table"><center>Ranking and Promotion Policies</center></h4></thead>
	    <tbody>
	    <tr><td><p><b>1. Eligibility</b><br><br><p class="policy"><b>a.</b> Every full-time faculty member, whether regular or probitionary, is eligible for promotion
	    to the next rank as soon as he/she accumulates the required number of points for that rank subject to the following conditions:<br></p></p>
	    <p class="policy1">ii. The highest rank a Bachelor's degree holder can attain is Instructor 6.<br><p class="policy1">iii. The highest rank a master's degree holder
	    can attain is Assistant Professor 6.<br><p class="policy1">iv. The highest rank a Doctoral degree holder can attain is Professor 3.<br><br><p class="policy">
	    <b>b.</b> The ranked faculty are full-time members of the college and graduate school of the University of the Immaculate Conception who have been appointed
	    by the President on the recommendation of the Ranking and Promotion Committee and the Deans (College and Graduate School).<br><br><p class="policy"><b>c.</b> If faculty
	    member is hired during the second semester, he/she is to undergo the point system before he/she will be given a rank.<br><br><p class="policy"><b>d.</b> Probitionary faculty
	    are ranked on thier second year. They are expected to complete thier master's degree within three years.<br><br><p class="policy"><b>e.</b>Aside
	    from meeting the required number of points in a particular sub-rank and other qualifications as stipulated in each rank, the faculty is promoted beyond:<br>
	    <p class="policy1">i. Instructor 6 if he/she has completed his/her master's degree.<br><p class="policy1">ii. Assistant Professor 9 when he/she has the overall
	    rating of Outstanding.<br><p class="policy1">iii. Associate Professor 6 when he/she has completed doctoral degress and/or he/she has reached outstanding service in teaching and other
	    qualifications.</p></p></p></p></p></p></p></p></p></p>
	    </td>
	    </tr>
	    <tr>
	       <td>
	       <p><br><b>2. Ranking Schedules</b><br><br><p class="policy"><b>a.</b> Ranking is done only once every year academic year.<br><br><p class="policy"><b>b.</b> As much as possible, the Ranking and
	       Promotion Committee meers on June 16 every year to process application for ranking.</p></p></p>
	       </td>
	    </tr>
	    <tr>
	       <td>
	       <br><p><b>3. Requirements</b><br><br><p class="policy"><b>a.</b> The faculty submits his/her application form with valid supporting documents to his/her Associate Dean not later than June 15.
	       <br><br><p class="policy"><b>b.</b> Non-submission of credentials and supporting documents shall be taken as waiver on the part of the faculty on his/her right to be ranked.<br>
	       <br><p class="policy"><b>c.</b> Credentials submitted after the deadline will be included in the next year's ranking.</p></p></p></p>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <p><b>4. Recommendation and Approval</b><br><br><p class="policy"><b>a.</b>Each member of the committee shall affix his/her signiture on the final sheet containing the new rank of the faculty
		  before submmitting to the VP Academics, who will then recommend the faculty rank and promotion to the university President.<br><br><p class="policy"><b>b.</b> The rank and Promotion Committee recommendation are forwarded to the VP for Academics
		  for endorsement to the President, who approves the rank, communicates in writting her approval or disapproval.<br><br><p class="policy"><b>c.</b> Upon approval, the Rank and Promotion Committee provides the VP Finance, VP Administration and VP Academics with a copy
		  of the approved ranks.<br><br><p class="policy"><b>d.</b> Each faculty member is finished a copy of the tally sheet which contains his/her present rank and the number of points credited to him/her after the approval of the university President.</p></p></p></p></p>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <br><p><b>5. Supplementary Provisions</b><br><br><p class="policy"><b>a. Instructor.</b> This is the rank gicen to Bachelor's degree holders and the highest rank a teacher with this degree is Instructor 6.<br><br><p class="policy"><b>b. Assistant Professor.</b> This is
		  rank for Master's degree holders. A teacher who becomes a full-fledge MA is automatomatically given the lowest rank in the Assistant Professor category. The same is true to any newly hired MA. He/She is given the lowest rank in this category. In this case, he/she is assigned
		  the rank of an <b>Assistant Professor 1</b> even if his/her merit or points fall short of the number of points in the scale.<br><br><p class="policy"><b>c. Associate Professor.</b> This is the rank given to the doctor's degree holders. A teacher who becomes a full-pledge doctor
		  is given the lowest rank in this category. The same is true for any newly-hired doctorate holder. He/She is assigned
		  the lowest rank under this category. Hence, his/her rank is <b>Associate Professor 1</b> regardless of whether his/her points are higher or lower than
		  the points expected in the scale. <br><br><p class="policy"><b>d. Full Professor.</b> This rank is given to one who has met the description of this category.</p></p></p></p></p>
	       </td>
	    </tr>
	    </tbody>
	    </table>
   <div id="status"></div><br>
   <div id="paginate"></div><br>      
   
	 </div>
         </div>   
         
      </div>
      
       
      <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
      </div>

</div>
   
   
</body>
</html>


