<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/login.css'; ?>" />
   <script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery-1.9.1.min.js'?>"></script>
<title>Ranking and Promotion</title>
<link rel="shortcut icon" href="<?php echo base_url().'images/uiclogow.png';?>" type="image/png">

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
<div class="layout">
        <div class="loginpage">
            <?php
            echo "<div class='instruction'><p>Please sign in with your UserID and Password.</p></div>";
            echo form_open('index.php/login/validatelogs');
            echo "<b class='names'>Username: </b>".form_input('username');
            echo "<br><br>";
            echo "<b class='names'>Password: </b>&nbsp".form_password('password');
            echo "<br><br>";
            echo "<div class='button'>".form_submit('submit','  LOGIN  ')."</div>";
            echo form_close();
            ?>
<div>
<div class="footer">
         <div class="foot">Copyright @ Team Fairytale 2013 | SAD SE PROJECT</div>
         <?php
         $validate = validation_errors();
         echo "<div id='validation'><div class='valid'><b>".$validate."</b></divS></div>";
         ?>
</div>
</div>
</body>
</html>