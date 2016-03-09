<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/login.css'; ?>" />
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">
</head>

<body>
<div class="layout">
        <div class="loginpage">
            <?php
            echo "<div class='instruction'><p>Your username has been changed. Please re-log in your account to continue.</p></div>";
            echo form_open('index.php/login/validatelogs');
            echo "<b>Username: </b>".form_input('username');
            echo "<br><br>";
            echo "<b>Password: </b>&nbsp".form_password('password');
            echo "<br><br>";
            echo "<div class='button'>".form_submit('submit','  LOGIN  ')."</div>";
            echo form_close();
            ?>
<div>
<div class="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
         <?php
         $validate = validation_errors();
         echo "<div id='validation'><b>".$validate."</b></div>";
         ?>
</div>
</div>
</body>
</html>