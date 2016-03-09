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
            <?php echo anchor('Rpc/index','Main');?> >
            <?php echo ('User Management');?> >>
            <?php echo ('View User');?> 
            </div>
         </div>
        <div id="right">
         <div class="content">
           <div id="head"><p>View User</p></div>
           <br>
           <?php
                $count = 0;
                $user_info = array();
        //Stores all the data fetched from the database to a 2D array $user_info
                foreach($allusers_data as $row){
                        $user_info[$count++] = array('user_username'=>$row['user_username'],
                                     'user_name'=>$row['user_fname']." ".$row['user_mname']." ".$row['user_lname'],
                                     'user_level'=>$row['userlevel_desc'],
                                     'user_status'=>$row['status']
                                     );}

        //Search User
	 $userlevel = array();
	 $userlevel[0] = "All Users";
	 $count = 1;
	 foreach($userlevel_data as $row){
	    $userlevel[$count] = $row->userlevel_desc;
	    $count++;
	    
	 }
	 
        echo form_open('index.php/users/search_user/search');
	echo "Userlevel: ".form_dropdown('userlevel', $userlevel)."&nbsp";
        echo "Name: ";
        $opt1='';
        $opt = 'placeholder="Enter User/Last Name"';
        echo form_input('keywords',$opt1,$opt)."&nbsp&nbsp";
	echo form_submit('','Search');
        echo form_close();
        echo "<br>";
//Activate or deactivate accounts
//Displays all users in tabular format

        if($allusers_data == NULL){
                echo 'No results found.';}

        else{
                echo "<div>";
                echo "<table class='tbl' border='0px' cellspacing='1px' cellpadding='0px'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th class='no'>"."No"."</th>";
                echo "<th class='username'>"."&nbsp Username &nbsp"."</th>";
                echo "<th>"."&nbsp Name &nbsp"."</th>";
                echo "<th class='userlevel'>"."&nbsp Userlevel &nbsp"."</th>";
                echo "<th class='status'>"."&nbsp Status &nbsp"."</th>";
                echo "</tr>";
                echo "</thead>";
                
                echo "<tbody>";
        for($count = 0; $count<count($allusers_data); $count++){
                echo "<tr>";
                $a = $user_info[$count]['user_username'];
                echo "<td>&nbsp".($count+1)."&nbsp</td>";
                echo "<td>&nbsp".anchor("index.php/rpc/loadupdateuser/".$a, $user_info[$count]['user_username'], array('user_username'=>$a))."&nbsp</td>";
                echo "<td>&nbsp".$user_info[$count]['user_name']."&nbsp</td>";
                echo "<td>&nbsp".$user_info[$count]['user_level']."&nbsp</td>";
    
    if($user_info[$count]['user_status']==1){//For activated accounts
        $num = 0;
        echo "<td>&nbsp".anchor("index.php/rpc/loadupdatestatus/".$num."/".$a, "Deactivate")."&nbsp</td>";
    }

    else if($user_info[$count]['user_status']==0){// For deactivated accounts
        $num = 1;
        echo "<td>&nbsp".anchor("index.php/rpc/loadupdatestatus/".$num."/".$a, "Activate")."&nbsp</td>";
    }
    echo "</tr>";
     
}
echo "</tbody>";
echo "</table>";
echo "</div>";
}

?>
          <br><br>
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



