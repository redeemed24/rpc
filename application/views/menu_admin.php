                <!--Code for menu starts here-->
		<p class="menu_head">User Management</p>
		<div class="menu_body">
		<?php echo anchor ('Rpc/loadadduser','<li>Add User</li>');?>
                <?php echo anchor('Rpc/loadallusers','<li>View User</li>');?>
		</div>
         
            <p class="menu_head">Faculty Management</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/loadaddfaculties','<li>Add Faculty</li>');?>
                <?php echo anchor('Rpc/loadallfaculties','<li>View Faculty</li>');?>  
		</div>
                
            <p class="menu_head">Program Management</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/loadaddprogram','<li>Add Program</li>');?>
                <?php echo anchor('Rpc/loadallprogram','<li>View Program</li>');?> 
		</div>
                
            <p class="menu_head">Qualification Management</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/loadaddqualification','<li>Add Qualification</li>');?>
                <?php echo anchor('Rpc/loadviewqualification','<li>View Qualification</li>');?> 
		</div>
            
            <p class="menu_head">School year Management</p>
		<div class="menu_body">
		<?php //echo anchor('Rpc/loadaddschoolyear','<li>Add School Year</li>');?>
                <?php echo anchor('Rpc/allschoolyear','<li>Set School Year</li>');?> 
		</div>
            
            <p class="menu_head">Ranking Management</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/loadaddrank','<li>Add Rank</li>');?>
                <?php echo anchor('Rpc/loadallrank','<li>View Rank</li>');?>
		</div>
              
            <p class="menu_head">Data Management</p>
		<div class="menu_body">
                <?php echo anchor('Rpc/loadallfacultiesrecords','<li>View Faculty Records</li>');?>
                <?php echo anchor('Rpc/loadreports','<li>Generate Reports</li>');?>
		</div>
            
            <p class="menu_head">Others</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/backupDb','<li id="backup">Backup Database</li>');?>
		</div>