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

<script type="text/javascript" laguage="javascript" src="<?php echo base_url().'js/style.js';?>"></script>

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
            <?php echo"User Management";?> >>
            <?php echo "View Users";?> >>>
            <?php echo"Update User";?>
            </div>
         </div>
        <div id="right">
         <div class="content">
         <div id="head"><p>Update User
	 <?php
	    foreach($schoolyear_data as $row){
	       //$SY = $row->SY_desc;
	       echo nbs(94)."CURRENT ACADEMIC YEAR: ".$row->SY_desc;
	    } 
	    ?>
	    </p></div>
	    
	 <?php echo "<div class='validation'><div class='valid'>".validation_errors()."</div></div>"; ?>
	 
<?php

$user_information = array(); // stores user information from database
$user_accountinfo = array(); // stores user account info from database

$count = 0;


foreach($user_info as $userinfo){
   $user_information[$count++] = array ('user_fname' => $userinfo->user_fname,
                                        'user_mname' => $userinfo->user_mname,
                                        'user_lname' => $userinfo->user_lname,
                                        'user_gender'=> $userinfo->user_gender,
                                        'program_id'=> $userinfo->program_id);
}

$count = 0;
foreach($user_account as $useraccount){
    $user_accountinfo[$count++] = array('user_username'=>$useraccount->user_username,
                                        'userlevel_id' =>$useraccount->userlevel_id,
                                        'status'=> $useraccount->status,
                                        'user_pass'=> $useraccount->user_pass,
                                        'user_status'=>$useraccount->status);
    
}


?>

<?php echo form_open('index.php/users/update_account/changepass/'.$user_accountinfo[0]['user_username']); ?>


<?php //Holds the value of the changes in user's information
   $data = array( 'user_fname','user_mname',
                    'user_lname','user_gender','program_id',
                    'user_username','user_pass','user_pass1', 'user_pass2');
?>
<br><br>

<h5>Old Password:</h5>
<?php
   echo "<input type = 'password' name = '$data[6]' required>";
   //echo form_password($data[6]);
   echo form_hidden('old_pass', $user_accountinfo[0]['user_pass']);
   echo form_hidden('user_status', 1); ?>
<br>
	 <p class="error">Password must be 8 characters long, and a maximum of 24.
         <div class="meter">
         </div>
	 </p>
	 <div class="password-container">
         <h5>New Password:</h5>
            <?php
             echo "<input class='strong-password' type = 'password' name = '$data[7]' required>";
	     ?>
	 <br>
         <h5>Confirm Password:</h5>
            <?php
	     echo "<input class='strong-password' type = 'password' name = '$data[8]' required>";
             ?>
	 
	 </div>
<br>

<?php echo form_submit('', 'Save Changes'); ?>
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

