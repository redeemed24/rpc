                <!--Code for menu starts here-->
		<p class="menu_head">User Management</p>
		<div class="menu_body">
		<?php echo anchor ('Rpc/loadadduser','<li>Add User</li>');?>
                <?php echo anchor('Rpc/loadallusers','<li>View User</li>');?>
		</div>
          
            <p class="menu_head">Others</p>
		<div class="menu_body">
		<?php echo anchor('Rpc/backupDb','<li id="backup">Backup Database</li>');?>
		</div>