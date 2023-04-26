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
                   

                    <div class="bg-white mt-3 rounded">
                        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center"> <a href="<?php echo base_url('admin/questions'); ?>" class="mr-2 back-icon text-decoration-none border px-2 py-1 rounded"><i class="fas fa-arrow-left"></i> </a> Question Answer</h6>
                        </div>



<div class="card-body ">

    <?php show_success_msg(); ?>
    <?php show_error_msg(); ?>


    <form action="<?php echo base_url('admin/update-question-details'); ?>" method="POST">

        <div class="wdinput mb-3 mt-2">

        	<label class=" font-weight-bold">Category <span class="text-danger">*</span></label>
        	<div class="wd-form">
                <?php if(!empty($categories)){ ?>
                    <?php foreach($categories as $category){ ?>
            		<label>
            			<input type="radio" required  name="cat_id" value="<?php echo $category->cat_id; ?>" <?php echo ($category->cat_id == $question->cat_id)?'checked':''; ?>> <?php echo $category->cat_name; ?>
            		</label>
                <?php } } ?>
        	</div>
        
        </div>

        <div class="wdinput form-group">
            <label class=" font-weight-bold">Question <span class="text-danger">*</span></label>
            <textarea type="text" class="form-control" name="question_description" placeholder="Enter Your Question" required><?php echo $question->question; ?></textarea> 
        </div>

        <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">


                            
        <ul id="tabs" class="nav nav-tabs" role="tablist">

            <?php if($question->question_type == 'binary'){ ?>
                <li class="nav-item">
                    <a id="tab-A" href="#pane-A" data-type="binary" class="nav-link <?php echo ($question->question_type == 'binary')?'active':''; ?>" data-toggle="tab" role="tab">Yes / No</a>
                </li>
            <?php } ?>

            <?php if($question->question_type == 'mcq'){ ?>
            <li class="nav-item">
                <a id="tab-B" href="#pane-B" data-type="mcq" class="nav-link <?php echo ($question->question_type == 'mcq')?'active':''; ?>" data-toggle="tab" role="tab">Option</a>
            </li>
            <?php } ?>

            <?php if($question->question_type == 'multiple'){ ?>
            <li class="nav-item">
                <a id="tab-C" href="#pane-C" data-type="multiple" class="nav-link <?php echo ($question->question_type == 'multiple')?'active':''; ?>" data-toggle="tab" role="tab">Multiple Selection</a>
            </li>
            <?php } ?>
        </ul>


    <div id="content" class="tab-content" role="tablist">

        <?php if($question->question_type == 'binary'){ ?>

        <div id="pane-A" class="card tab-pane fade tab-A <?php echo ($question->question_type == 'binary')?'show active':''; ?>" role="tabpanel" aria-labelledby="tab-A">

            <?php if(!empty($question->options)) {
            ?>

           <div class="card-body">
               <div class="wdinput form-group border-bottom pb-3">
                <input type="hidden" class="form-control" name="option[]" value="yes">
                    <label class=" font-weight-bold">Yes <span class="text-danger">*</span></label>
                    <textarea type="text" class="form-control" name="option_answer[]" placeholder="Enter Your Answer" required><?php echo $question->options[0]->option_answer; ?></textarea> 

                    <input type="text" class="form-control" name="option_point[]"  value="<?php echo $question->options[0]->option_point; ?>" placeholder="Enter Points" required>

                    <input type="hidden" name="option_id[]" value="<?php echo $question->options[0]->id; ?>">
                </div>



                 <div class="wdinput form-group border-bottom pb-3">
                    <input type="hidden" class="form-control" name="option[]" value="no">
                    <label class=" font-weight-bold">No <span class="text-danger">*</span></label>
                    <textarea type="text" class="form-control" name="option_answer[]" placeholder="Enter Your Answer" required><?php echo $question->options[1]->option_answer; ?></textarea> 

                    <input type="text" class="form-control" name="option_point[]" value="<?php echo $question->options[1]->option_point; ?>" placeholder="Enter Points" required>
                    <input type="hidden" name="option_id[]" value="<?php echo $question->options[1]->id; ?>">
                </div>
            </div>

             <?php } ?>
        </div>

        <?php } ?>


        <?php if($question->question_type == 'mcq'){ ?>

        <div id="pane-B" class="card tab-pane fade tab-B <?php echo ($question->question_type == 'mcq')?'show active':''; ?>" role="tabpanel" aria-labelledby="tab-B">
           <div class="card-body">
                <div id="attributes">

                    <?php if(!empty($question->options)) {
                        foreach($question->options as $option){
                        ?>
                    <div class="attr">
                       <div class="wdinput form-group border-bottom pb-3">
                            <label class=" font-weight-bold">Option  <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="option[]" placeholder="Enter Option" required><?php echo $option->options; ?></textarea> 

                            <textarea class="form-control" name="option_answer[]" placeholder="Enter Your Answer" required><?php echo $option->option_answer; ?></textarea>

                            <input type="text" class="form-control" name="option_point[]" placeholder="Enter Points" value="<?php echo $option->option_point; ?>" required>
                            <input type="hidden" name="option_id[]" value="<?php echo $option->id; ?>">
                            <button class="btn btn-danger mt-2 remove2 deleteOption" id="<?php echo $option->id; ?>" type="button">Remove</button>
                        </div> 
                    </div>
                    <?php }} ?>
                </div>
        
                <div class="wdinput form-group text-right">
                    <button class="btn btn-primary update-add" type="button">Add Option</button> 
                </div>                              
            </div>
        </div>

        <?php } ?>


        <?php if($question->question_type == 'multiple'){ ?>

        <div id="pane-C" class="card tab-pane fade tab-C <?php echo ($question->question_type == 'multiple')?'show active':''; ?>" role="tabpanel" aria-labelledby="tab-C">
            <div class="card-body">
                <div id="attributes1">

                    <?php if(!empty($question->options)) {
                        foreach($question->options as $option){
                        ?>

                    <div class="attr1">
                       <div class="wdinput form-group border-bottom pb-3">
                            <label class=" font-weight-bold">Option  <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="option[]" placeholder="Enter Option" required><?php echo $option->options; ?></textarea> 

                            <textarea class="form-control" name="option_answer[]" placeholder="Enter Your Answer" required><?php echo $option->option_answer; ?></textarea>

                            <input type="text" class="form-control" name="option_point[]" placeholder="Enter Points" value="<?php echo $option->option_point; ?>" required>

                            <input type="hidden" name="option_id[]" value="<?php echo $option->id; ?>">

                            <button class="btn btn-danger mt-2 remove3 deleteOption" id="<?php echo $option->id; ?>" type="button">Remove</button>
                        </div> 
                    </div>

                    <?php }} ?>

                </div>

                <div class="wdinput form-group text-right">
                    <button class="btn btn-primary update-add1" type="button">Add Option</button> 
                </div>                                         
            </div>
        </div>

        <?php } ?>

    </div>


        <div class="wdinput form-group mt-3">
           <button class="btn btn-primary">Submit</button>
        </div>
        <input type="hidden" name="question_type" class="question_type" value="binary">
    </form>
</div>
</div>
</div>
</div>         
</div>

<?php include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('click','.deleteOption',function(){

            var optionId = $(this).attr('id');

            if(optionId != "" && optionId != undefined){
                $.ajax({
                    url: "<?php echo base_url('admin/option/delete'); ?>",
                    method: 'POST',
                    data: {'optionId' : optionId},
                    success: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });
</script>
        
            