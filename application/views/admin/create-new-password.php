<!--start here meta section-->
<?php include('include/meta.php'); ?>
<!--start here end meta  section-->

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image p-5">
                                <img src="<?php echo base_url(); ?>assets/img/logo-2.png" class="img-fluid">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Create New Password</h1>
                                        
                                    </div>
                                    <form class="user" method="post" action="<?php echo base_url('user/change-password'); ?>">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Enter New Password" name="password" required>
                                            <?php echo form_error('password'); ?>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Enter Confirm Password" name="cpassword" required>
                                            <?php echo form_error('cpassword'); ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Change Password</button>
                                        <input type="hidden" name="token" value="<?php echo $emailData->forgot_pass_token; ?>">
                                        <input type="hidden" name="userId" value="<?php echo $emailData->id; ?>">
                                        <input type="hidden" name="email" value="<?php echo $emailData->email; ?>">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url('user/register'); ?>">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url(); ?>">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!--start here footer section-->
<?php include('include/footer.php'); ?>
<!--start here end footer  section-->

</body>

</html>