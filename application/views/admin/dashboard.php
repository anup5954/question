<!--start here meta section-->
<?php include('include/meta.php'); ?>
<!--start here end meta  section-->
<div id="wrapper">
        <!-- Sidebar -->
        <?php include('include/sidebar.php'); ?>
        <!-- Sidebar -->

        <!-- Header -->
        <?php include('include/header.php'); ?>
        <!-- Header -->

        <!-- Content -->
               <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-orange text-uppercase mb-1" style="height:50px">
                                               Total of Question</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $countQues; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-orange text-uppercase mb-1" style="height:50px">
                                                Total of User</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo count($users); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-orange text-uppercase mb-1" style="height:50px">User Submit Question
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h2 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $countUserSubmit; ?></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-orange text-uppercase mb-1" style="height:50px">
                                                Total of Category</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $countCat; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <!-- <div class="col-12">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">New Users</h6>
                                    
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email Id</th>
                                            <th>Phone number</th>
                                            <th>Report</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php if(!empty($users)){
                                            $sno = 1; 
                                            foreach($users as $user){
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $sno++; ?></td>
                                                <td><?php echo $user->firstname.' '.$user->lastname; ?></td>
                                                <td><?php echo $user->email; ?></td>
                                                <td><?php echo $user->mobile; ?></td>

                                                <?php if(!empty($user->report_generated)) { ?>
                                                    <td><a href="<?php echo base_url('uploads/'.$user->report_link); ?>" class="text-decoration-none text-success">Complete</td>
                                                <?php } else { ?>
                                                    <td><a href="javascript:void(0)" class="text-decoration-none text-warning" disable>Pending</td>
                                                <?php } ?>
                                                <td class="text-center">
                                                  <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider round"></span>
                                                  </label>
                                                  <button class="btn text-danger p-0 ml-3"data-toggle="modal" data-target="#deleteuserModal"><i class="fas fa-trash"> </i></button>
                                                  <button class="btn text-warning p-0 ml-3"data-toggle="modal" data-target="#edituserModal"><i class="fas fa-edit"> </i></button>
                                                </td>
                                            </tr>
                                        <?php }}?>
                                        
                                    </tbody>
                                </table>
                            </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Pie Chart -->
                       
                    </div>

                  

                </div>
        <!-- Content -->        
               
</div>

               <?php include('include/footer.php'); ?>
        
            