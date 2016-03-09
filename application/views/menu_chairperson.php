                <!--Code for menu starts here-->
		
            <p class="menu_head">User Management</p>
		<div class="menu_body">
                <?php echo anchor('Rpc/loadalluserschaiperson','<li>View Users</li>');?>  
		</div>
                
            <p class="menu_head">Faculty Management</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/loadaddfaculties','<li>Add Faculty</li>');?>
                <?php echo anchor('Rpc/loadallfaculties','<li>View Faculty</li>');?>  
		</div>      
              
            <p class="menu_head">Data Management</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/listchecklist','<li>Fill Up Checklist</li>');?>
                <?php echo anchor('Rpc/loadallfacultiesrecords','<li>View Faculty Records</li>');?>
                <?php echo anchor('Rpc/loadreports','<li>Generate Reports</li>');?>
		</div>
            
            <p class="menu_head">Others</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/backupDb','<li id="backup">Backup Database</li>');?>
		</div>