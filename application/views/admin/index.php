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
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <?php show_success_msg(); ?>
                                    <?php show_error_msg(); ?>

                                    <form class="user" action="<?php echo base_url(); ?>user/login" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address" name="email" required>
                                            <?php echo form_error('email'); ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password" required>
                                            <?php echo form_error('password'); ?>
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url('user/for-got-password'); ?>">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url('user/register'); ?>">Create an Account!</a>
                                    </div>
                                </div>
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