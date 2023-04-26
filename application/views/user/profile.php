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
                    <?php show_success_msg(); ?>
                    <?php show_error_msg(); ?>
                    <!-- Content Row -->
                    <form method="post" action="<?php echo base_url('user/update-profile'); ?>">

                    <div class="row">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="firstname" placeholder="First Name" class="form-control" value="<?php echo set_value('firstname',$user->firstname); ?>">
                            </div>
                            <?php echo form_error('firstname'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="lastname" placeholder="Last Name" class="form-control" value="<?php echo set_value('lastname',$user->lastname); ?>">
                            </div>
                            <?php echo form_error('lastname'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="number" name="phonenumber" placeholder="Phone Number" class="form-control" value="<?php echo set_value('phonenumber',$user->mobile); ?>">
                            </div>
                            <?php echo form_error('phonenumber'); ?>
                        </div>
                         
                    </div>


                    <div class="row">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="designation" placeholder="Designation" class="form-control" value="<?php echo set_value('designation',$user->designation); ?>">
                            </div>
                            <?php echo form_error('designation'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="company_name" placeholder="Company Name" class="form-control" value="<?php echo set_value('company_name',$user->company_name); ?>">
                            </div>
                            <?php echo form_error('company_name'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="number" name="num_emp" placeholder="No of Employees" class="form-control" value="<?php echo set_value('num_emp',$user->num_emp); ?>">
                            </div>
                            <?php echo form_error('num_emp'); ?>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="company_revenue" placeholder="Company Revenue" class="form-control" value="<?php echo set_value('company_revenue',$user->company_revenue); ?>">
                            </div>
                            <?php echo form_error('company_revenue'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="text" name="website" placeholder="Company Website" class="form-control" value="<?php echo set_value('website',$user->website); ?>">
                            </div>
                            <?php echo form_error('website'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <textarea placeholder="Office Address" name="office_address" class="form-control"><?php echo set_value('office_address',$user->office_address); ?></textarea>
                            </div>
                            <?php echo form_error('office_address'); ?>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                              <button class="btn btn-primary"> Update Profile</button>
                            </div>
                        </div>


                </form>


                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Password Update</h1>
                        
                    </div>

                    <form method="post" action="<?php echo base_url('user/update-password'); ?>">
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="password" name="currentpwd" placeholder="Current Password" class="form-control">
                            </div>
                            <?php echo form_error('currentpwd'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="password" name="newpwd" placeholder="New Password" class="form-control">
                            </div>
                            <?php echo form_error('newpwd'); ?>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                                <input type="password" name="confirmpwd" placeholder="Confirm Password" class="form-control">
                            </div>
                            <?php echo form_error('confirmpwd'); ?>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="wd-form">
                              <button class="btn btn-primary"> Update Password</button>
                            </div>
                        </div>

                        
                    </div>
                </form>
                    <!-- Content Row -->


                  

                </div>
        <!-- Content -->        
               
</div>

               <?php include('include/footer.php'); ?>
        
            