<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/style.css'; ?>" />
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js'?>"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery-1.4.4.min.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery-1.9.1.min.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/demo.css'?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/styl.css'?>"/>
<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/pschecker.js'; ?>"></script>

<link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/menu.css'?>" />
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
	
	
});
</script>

 <script type="text/javascript">
        $(document).ready(function () {
           
            //Demo code
            $('.password-container').pschecker({ onPasswordValidate: validatePassword, onPasswordMatch: matchPassword });

            var submitbutton = $('.submit-button');
            var errorBox = $('.error');
            errorBox.css('visibility', 'hidden');
            submitbutton.attr("disabled", "disabled");

            //this function will handle onPasswordValidate callback, which mererly checks the password against minimum length
            function validatePassword(isValid) {
                if (!isValid)
                    errorBox.css('visibility', 'visible');
                else
                    errorBox.css('visibility', 'hidden');
            }
            //this function will be called when both passwords match
            function matchPassword(isMatched) {
                if (isMatched) {
                    submitbutton.addClass('unlocked').removeClass('locked');
                    submitbutton.removeAttr("disabled", "disabled");
                }
                else {
                    submitbutton.attr("disabled", "disabled");
                    submitbutton.addClass('locked').removeClass('unlocked');
                }
            }
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

<script type="text/javascript">
			function program_check(sel, cb)
			{
				for (var i = 0; i < cb.length; i++) {
					cb[i].disabled = (sel.value == i);
				}
			}
			window[window.attachEvent ? 'attachEvent' : 'addEventListener']((window.attachEvent ? 'on' : '') + 'load', function(){document.form1.program.onchange();}, false);
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
            <?php echo ('User Management');?> >>
            <?php echo ('Add User');?>
            </div>
         </div>
        <div id="right">
	 
         <?php echo form_open('users/Add_user/adduser');?>

         <?php
         $data = array( 'user_fname','user_mname','user_lname','user_gender','program_id','user_username','user_pass','user_pass1'); 
         ?>
         <div class="content">
            
            <div id="head"><p>Add User
	     <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(102)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	    
	 <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>"; ?>
         
	 <div class="insidecont">
	 <div class="rghtcnt">
	 <h5> First Name: </h5>
            <?php
                  $opt = 'placeholder="Enter First Name"';
		  echo "<input type = 'text' name = '$data[0]' required>";
                  //echo form_input($data[0],'',$opt); ?>
            <br>

         <h5>Middle Name:</h5>
            <?php
            $opt = 'placeholder="Enter Middle Name"';
	     echo "<input type = 'text' name = '$data[1]' required>";
            //echo form_input($data[1],'',$opt); ?>
            <br>

         <h5>Last Name:</h5>
            <?php
            $opt = 'placeholder="Enter Last Name"';
             echo "<input type = 'text' name = '$data[2]' required>";
	    //echo form_input($data[2],'',$opt); ?>
         </div>   
	 
	 <div class="lftcnt">
         <h5>Gender:</h5>
            Male
            <?php echo form_radio($data[3],'Male'); ?>
         
            Female
            <?php echo form_radio($data[3],'Female'); ?>
            <br><br>
            
         
         <h5>User Level:</h5>
            <?php 
               $userlevel_id = array();
	       
	       if($this->session->userdata('userlevel_id')==4){
		  $count = 0;
	       }
	       
	       else if($this->session->userdata('userlevel_id')==1){
               $count=1;
	       }
      
               foreach($userlevel_data as $userlevelid){
		  if($this->session->userdata('userlevel_id')==4){
		     if($userlevelid->userlevel_id !=4){
		     $userlevel_id [$count++]= $userlevelid->userlevel_desc;
		     }
		  }
		  
		  else if($this->session->userdata('userlevel_id')==1){
		        if($userlevelid->userlevel_id !=1){
		       $userlevel_id [$count++]= $userlevelid->userlevel_desc;
		     }
		  }
	       }
	       
                  echo form_dropdown('userlevel_id', $userlevel_id);
            ?>
	 </div>
	 </div>
            
         <h5>Program:</h5>
            <?php
               $program_list = array();
	       $program_check = array();
               $count=0;
	       $count1 = 1;
               foreach($program_data as $program1){
                 $program_list [$count++] =$program1->program_name;
		 $program_check[$count1++] = $program1->program_name;
               }
	    
	       
            //echo "<div>".form_dropdown('program', $program_list)."</div>";
	    
	  
	    
            /*echo "<br><h5>"."Program to Rank:"."</h5>";

            $options = array();
               foreach($program_data as $program){
               echo form_checkbox('options[]', $program->program_id)." "."<span class='programlist'>".$program->program_name."</span>"."</br>";
	         
            }*/
            ?>
	    
	    <select name="program" id="program" class="drop_down" onchange="program_check(this, this.form.options);">
							<?php
							
							for($i=0; $i<count($program_list); $i++){
							echo "<option value='$i'>$program_list[$i]</option>";
							}
							?>
	     </select>
						        <?php
							//echo count($program_list);
							echo br(2);
							for($i=1; $i<=count($program_check); $i++){
						        echo "<input type='checkbox'  name='options[]' id= 'options' value=$i />";
							echo "<span class='programlist'>";
							echo $program_check[$i].br(1);
							}
							?>
	   
	    
	    
         <br>
         <h5>Username:</h5>
            <?php
             $opt = 'placeholder="UserName"';
              echo "<input type = 'text' name = '$data[5]' required>";
	     //echo form_input($data[5],'',$opt); ?>
         <br>
	 <p class="error">Password must be 8 characters long, and a maximum of 24.
         <div class="meter">
         </div>
	 </p>
	 <div class="password-container">
         <h5>Password:</h5>
            <?php
             echo "<input class='strong-password' type = 'password' name = '$data[6]' required>";
	    //echo form_password($data[6],'',$opt); ?>
	 <br>
         <h5>Confirm Password:</h5>
            <?php
	     echo "<input class='strong-password' type = 'password' name = '$data[7]' required>";
            //echo form_password($data[7],'',$opt); ?>
	 
	 </div>
	<br>
         <h5>Account Status:</h5>
            <?php
               $userstatus = array('Activate', 'Deactivate');
               echo form_dropdown('user_status', $userstatus);
            ?>
         <br><br>
           <?php echo form_submit('','Add User');
		  echo form_reset('', 'Clear'); ?>

            <?php echo form_close(); ?>
         
         
         </div>
      </div>
   </div>
      
       <div id="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
         </div>
</div>
   
   
</body>
</html>
