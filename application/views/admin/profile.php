<!--start here meta section-->
<?php include('include/meta.php'); ?>
<!--start here end meta  section-->
<div id="wrapper">
        <!-- Sidebar -->
        <?php include('include/user-sidebar.php'); ?>
        <!-- Sidebar -->

        <!-- Header -->
        <?php include('include/header.php'); ?>
        <!-- Header -->

        <!-- Content -->
               <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                        
                    </div>

                    <!-- Content Row -->
                    <form>
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="fname" placeholder="Full Name" class="form-control">
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="email" name="emailid" placeholder="Email Id" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="number" name="phonenumber" placeholder="Phone Number" class="form-control">
                            </div>
                        </div>

                        
                    </div>
                </form>


                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Password Update</h1>
                        
                    </div>

                    <form>
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="password" name="currentpwd" placeholder="Current Password" class="form-control">
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="password" name="newpwd" placeholder="New Password" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="password" name="confirmpwd" placeholder="Confirm Password" class="form-control">
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                              <button class="btn btn-primary"> Submit</button>
                            </div>
                        </div>

                        
                    </div>
                </form>
                    <!-- Content Row -->


                  

                </div>
        <!-- Content -->        
               
</div>

               <?php include('include/footer.php'); ?>
        
            