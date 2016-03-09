<?php
               if($this->session->userdata('userlevel_id')==1){
                     include '../application/views/menu_admin.php';
              }
              
              else if($this->session->userdata('userlevel_id')==2){
                     include '../application/views/menu_chairperson.php';
                     //echo "Load menus & pages for Chairperson";
              }
              
               else if($this->session->userdata('userlevel_id')==3){
                     include '../application/views/menu_committee.php';
              }
              
              else if($this->session->userdata('userlevel_id')==4){
                     include '../application/views/menu_superuser.php';
              }
               ?>