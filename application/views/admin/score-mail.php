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
                        <h1 class="h3 mb-0 text-gray-800">Send Mail (<?php echo $userData->firstname.' '.$userData->lastname; ?>)</h1>
                        
                    </div>

                    <!-- Content Row -->
                    <form action="<?php echo base_url('admin/sned-score/mail/'.$userData->id); ?>" method="POST">
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-12 mb-12">
                            <label><b>Email Subject:</b></label>
                            <div class="wd-form">
                                <input type="text" name="email_subject" placeholder="Enter Email Subject" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-12">
                            <label><b>Email Body:</b></label>
                            <div class="wd-form">
                                <textarea name="email_content" placeholder="Email Content" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 mb-12">
                            <label></label>
                            <div class="wd-form">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                        
                    </div>
                </form>


                </div>
        <!-- Content -->        
               
</div>

               <?php include('include/footer.php'); ?>
        
            