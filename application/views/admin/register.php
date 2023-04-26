<!--start here meta section-->
<?php include('include/meta.php'); ?>
<!--start here end meta  section-->
    
    <div class="container">

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
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>

                            <?php show_success_msg(); ?>
                            <?php show_error_msg(); ?>

                            <form class="user" action="<?php echo base_url(); ?>user/save" method="POST">
                           
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" value="<?php echo set_value('firstname'); ?>" class="form-control form-control-user" id="firstname"
                                            placeholder="First Name" name="firstname" required>
                                            <?php echo form_error('firstname'); ?>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" value="<?php echo set_value('lastname'); ?>" class="form-control form-control-user" id="lastname"
                                            placeholder="Last Name" name="lastname" required>
                                            <?php echo form_error('lastname'); ?>
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <input type="email" value="<?php echo set_value('email'); ?>" class="form-control form-control-user" id="email"
                                        placeholder="Email Address" name="email" required>
                                        <?php echo form_error('email'); ?>
                                </div>

                                <div class="form-group">
                                    <input type="number" value="<?php echo set_value('mobile'); ?>" class="form-control form-control-user" id="mobile"
                                        placeholder="Mobile Number" name="mobile" required pattern="[6789][0-9]{9}">
                                        <?php echo form_error('mobile'); ?>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" placeholder="Password" name="password" required>
                                            <?php echo form_error('password'); ?>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                                            <?php echo form_error('cpassword'); ?>
                                    </div>
                                    
                                     
                                    <div class="col-12 mt-3">
                                        <label class="text-danger noted-line">First you have to do the payment (Rs 200) then only you can sign in this page </label>
                                    </div>
                                </div>

                                <input id="pay-btn" type="submit" value="Pay Amount" class="btn btn-primary btn-user btn-block" />
                                
                            </form>
                            
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url('user/for-got-password'); ?>">Forgot Password?</a>
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

     <?php include('include/footer.php'); ?>

</body>

</html>