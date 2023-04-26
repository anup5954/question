<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('user/dashboard'); ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="<?php echo base_url(); ?>assets/img/logo-2.png">
                </div>
                
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/category'); ?>">
                    <i class="fas fa-list-alt"></i>
                    <span>Category</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/questions'); ?>">
                    <i class="fas fa-question-circle"></i>
                    <span>Question Answer</span></a>
            </li>

           <!--  <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/users'); ?>">
                    <i class="fas fa-user"></i>
                    <span>User</span></a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseorder" aria-expanded="true" aria-controls="collapseorder">
                    <i class="fas fa-user"></i>
                    <span>Users</span>
                </a>
                <div id="collapseorder" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Users Data</h6>
                        <a class="collapse-item" href="<?php echo base_url('admin/users'); ?>">UsersList</a>
                        <a class="collapse-item" href="<?php echo base_url('admin/user-score'); ?>">Users Report</a>
                    </div>
                </div>
            </li>

           <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseorder" aria-expanded="true" aria-controls="collapseorder">
                    <i class="fas fa-desktop"></i>
                    <span>Analytics</span>
                </a>
                <div id="collapseorder" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Analytics Data</h6>
                        <a class="collapse-item" href="analytics-dashboard.php">Dashboard</a>
                        <a class="collapse-item" href="poc.php">POC</a>
                    </div>
                </div>
            </li>  -->
            
            
            
            
            <!-- Nav Item - Charts -->
            
        </ul>