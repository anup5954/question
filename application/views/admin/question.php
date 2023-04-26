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
                    <div class="heading-section d-flex">
                   

                    
                    </div>

                    <div class="bg-white rounded">
                        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex">

                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center"> Questions</h6>

                            <a href="<?php echo base_url('admin/question-details'); ?>"class="btn ml-auto bg-primary"> <i class="fas fa-plus"></i> Add Question</a>
                        </div>
                        <div class="card-body">

                            <?php show_success_msg(); ?>
                            <?php show_error_msg(); ?>


                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableQuestion" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Question</th>
                                            <th>Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>

                                        <?php if(!empty($questions)){
                                            $i = 1;
                                            foreach($questions as $question){
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $question->id; ?></td>
                                                <td><?php echo $question->cat_name; ?></td>
                                                <td class="quesdata"><?php echo $question->question; ?></td>
                                                <td><?php echo date('d-m-Y',strtotime($question->created_at)); ?></td>
                                                <td>
                                                  <a href="<?php echo base_url('admin/question/edit/'.$question->id); ?>" class="btn text-warning"><i class="fas fa-edit"> </i></a>

                                                  <a class="btn text-danger" href="<?php echo base_url('admin/question/delete/'.$question->id); ?>" onClick="return confirm('Are you sure want to delete?'); "><i class="fas fa-trash"> </i></a>
                                                </td>
                                            </tr>
                                        <?php }} ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

               
        <!-- Content -->        
               
</div>

<?php include('include/footer.php'); ?>
        
            