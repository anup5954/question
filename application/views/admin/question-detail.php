<!--start here meta section-->
<?php include('include/meta.php'); ?>
<style type="text/css">
    .btn-tick{
        float: right;
        padding: 5px;
    }
</style>
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


    <form action="<?php echo base_url('admin/add-question-details'); ?>" method="POST" id="form-question">

        <div class="wdinput mb-3 mt-2">

        	<label class=" font-weight-bold">Category <span class="text-danger">*</span></label>
        	<div class="wd-form">
                <?php if(!empty($categories)){ ?>
                    <?php foreach($categories as $category){ ?>
            		<label>
            			<input type="radio" required  name="cat_id" value="<?php echo $category->cat_id; ?>"> <?php echo $category->cat_name; ?>
            		</label>
                <?php } } ?>
        	</div>
        
        </div>

        <div class="wdinput form-group">
            <label class=" font-weight-bold">Question <span class="text-danger">*</span></label>
            <textarea type="text" class="form-control" id="question_description" name="question_description" placeholder="Enter Your Question" required></textarea> 
        </div>


                            
        <ul id="tabs" class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a id="tab-A" href="#pane-A" data-type="binary" class="nav-link active" data-toggle="tab" role="tab">Yes / No</a>
            </li>
            <li class="nav-item">
                <a id="tab-B" href="#pane-B" data-type="mcq" class="nav-link" data-toggle="tab" role="tab">Option</a>
            </li>
            <li class="nav-item">
                <a id="tab-C" href="#pane-C" data-type="multiple" class="nav-link" data-toggle="tab" role="tab">Multiple Selection</a>
            </li>
        </ul>


    <div id="content" class="tab-content" role="tablist">

        <div id="pane-A" class="card tab-pane fade show active tab-A" role="tabpanel" aria-labelledby="tab-A">
           
           <div class="card-body">
               <div class="wdinput form-group border-bottom pb-3">
                    <label class=" font-weight-bold">Yes <span class="text-danger">*</span></label>

                    <input type="text" class="form-control" name="option_header[]" placeholder="Enter Header">

                    <select class="form-control" name="image_option[]">
                        <option value="">Select Bullet</option>
                        <option value="greenbullet.png">Green</option>
                        <option value="yellowbullet.png">Yellow</option>
                        <option value="redbullet.png">Red</option>
                    </select>

                     <input type="hidden" class="form-control" name="option[]" value="yes"> 
                    <textarea class="form-control" id="option_answer_yes" name="option_answer[]" placeholder="Enter Your Answer"></textarea> 

                    <input type="number" class="form-control" name="option_point[]" placeholder="Enter Points" required pattern= "[0-9]+" step="0.1" title="Number Only">
                </div>



                 <div class="wdinput form-group border-bottom pb-3">
                    <input type="hidden" class="form-control" name="option[]" value="no"> 
                    <label class=" font-weight-bold">No <span class="text-danger">*</span></label>

                    <input type="text" class="form-control" name="option_header[]" placeholder="Enter Header">

                    <select class="form-control" name="image_option[]">
                        <option value="">Select Bullet</option>
                        <option value="greenbullet.png">Green</option>
                        <option value="yellowbullet.png">Yellow</option>
                        <option value="redbullet.png">Red</option>
                    </select>

                    <textarea type="text" class="form-control" id="option_answer_no" name="option_answer[]" placeholder="Enter Your Answer"></textarea> 

                    <input type="number" class="form-control" name="option_point[]" placeholder="Enter Points" required pattern= "[0-9]+" step="0.1" title="Number Only">
                </div>
            </div>
        </div>


        <div id="pane-B" class="card tab-pane fade tab-B" role="tabpanel" aria-labelledby="tab-B">
           <div class="card-body">
                <div id="attributes">
                    <div class="attr">
                       <div class="wdinput form-group border-bottom pb-3">
                            <label class=" font-weight-bold">Option  <span class="text-danger">*</span></label>
                            <textarea class="form-control option-class" name="option[]" placeholder="Enter Option"></textarea>

                            <input type="text" class="form-control" name="option_header[]" placeholder="Enter Header" >

                            <select class="form-control" name="image_option[]">
                                <option value="">Select Bullet</option>
                                <option value="greenbullet.png">Green</option>
                                <option value="yellowbullet.png">Yellow</option>
                                <option value="redbullet.png">Red</option>
                            </select> 

                            <textarea class="form-control" id="option_answer_mcq_1" name="option_answer[]" placeholder="Enter Your Answer" data-count=1 ></textarea> 

                            <input type="number" class="form-control" name="option_point[]" placeholder="Enter Points" pattern= "[0-9]+" step="0.1" title="Number Only">
                            <button class="btn btn-danger mt-2 remove" type="button">Remove</button>
                        </div> 
                    </div>
                </div>
        
                <div class="wdinput form-group text-right">
                    <button class="btn btn-primary add" type="button">Add Option</button> 
                </div>                              
            </div>
        </div>


        <div id="pane-C" class="card tab-pane fade tab-C" role="tabpanel" aria-labelledby="tab-C">
            <div class="btn-tick">
                <button type="button" class="btn btn-primary allTickPopup">All Tick</button>
                <button type="button" class="btn btn-primary ifAnyUntickPopup">If Any Untick</button>
            </div>
            <div class="card-body">
                <div id="attributes1">
                    <div class="attr1">
                       <div class="wdinput form-group border-bottom pb-3">
                            <label class=" font-weight-bold">Option  <span class="text-danger">*</span></label>
                            <textarea class="form-control option-class" name="option[]" placeholder="Enter Option"></textarea>

                            <input type="text" class="form-control" name="option_header[]" placeholder="Enter Header">

                            <select class="form-control" name="image_option[]">
                                <option value="">Select Bullet</option>
                                <option value="greenbullet.png">Green</option>
                                <option value="yellowbullet.png">Yellow</option>
                                <option value="redbullet.png">Red</option>
                            </select>  

                            <textarea class="form-control" id="option_answer_multi_1" name="option_answer[]" placeholder="Enter Your Answer" data-multi=1 ></textarea>

                            <input type="number" class="form-control" name="option_point[]" placeholder="Enter Points" pattern= "[0-9]+" step="0.1" title="Number Only">
                            <button class="btn btn-danger mt-2 remove1" type="button">Remove</button>
                        </div> 
                    </div>
                </div>

                <div class="wdinput form-group text-right">
                    <button class="btn btn-primary add1" type="button">Add Option</button> 
                </div>                                         
            </div>
        </div>

    </div>

    <!-- Tick Popup -->

    <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="allTickPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">All Tick Answer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>All Tick Answer Header</label>
                    <textarea class="form-control" id="all_tick_answer_header" name="all_tick_answer_header" placeholder="All tick header"></textarea><br>
                <label>All Tick Answer Footer</label>
                    <textarea class="form-control" id="all_tick_answer_footer" name="all_tick_answer_footer" placeholder="All tick footer"></textarea>
              </div>
            </div>
          </div>
        </div>


        <div class="modal fade bd-example-modal-lg" id="ifAnyUntickPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">If Any Untick Answer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>If Any Untick Answer Header</label>
                    <textarea class="form-control" id="if_any_untick_answer_header" name="if_any_untick_answer_header" placeholder="If Any Untick header"></textarea><br>
                <label>If Any Untick Answer Footer</label>
                    <textarea class="form-control" id="if_any_untick_answer_footer" name="if_any_untick_answer_footer" placeholder="If Any Untick footer"></textarea>
              </div>
            </div>
          </div>
        </div>

    <!-- End Popup -->


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
   <script>
       CKEDITOR.replace('question_description',{ height: '100px' });
       CKEDITOR.replace('option_answer_yes',{ height: '100px' });
       CKEDITOR.replace('option_answer_no',{ height: '100px' });
       CKEDITOR.replace('option_answer_mcq_1',{ height: '100px' });
       CKEDITOR.replace('option_answer_multi_1',{ height: '100px' });
       CKEDITOR.replace('all_tick_answer_header',{ height: '100px' });
       CKEDITOR.replace('all_tick_answer_footer',{ height: '100px' });

       CKEDITOR.replace('if_any_untick_answer_header',{ height: '100px' });
       CKEDITOR.replace('if_any_untick_answer_footer',{ height: '100px' });
    </script>
    
    <script type="text/javascript">
    
    $(document).ready(function(){


        $("#form-question").submit( function(e) {

            var messageLength = CKEDITOR.instances['question_description'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                alert( 'Please fill all the fields');
                e.preventDefault();
                return false;
            }

                

            $('.tab-pane').each(function(){

                if($(this).hasClass('active')){
                   
                    $(this).find("textarea").each(function(){

                        if(typeof(this.id) != undefined && this.id != ""){
                            let ckId = this.id;

                            var messageLength = CKEDITOR.instances[ckId].getData().replace(/<[^>]*>/gi, '').length;
                            if( !messageLength ) {
                                alert( 'Please fill all the fields');
                                e.preventDefault();
                                return false;
                            }

                        }
                        
                    });
                }
            });
        });


        $('.nav-link').on('click',function(){

            $('.question_type').val($(this).data('type'));

            var tabId = $(this).attr('id');

            $('.tab-pane').each(function(){

                if($(this).hasClass(tabId)){
                    $('.'+tabId).find('input').prop("required",true);
                    $(this).find('.option-class').prop("required",true);
                    
                } else {
                    $(this).find('input').prop("required",false);
                    $(this).find('.option-class').prop("required",false);
                    $(this).find('input,textarea').val("");
                    $(this).find("textarea").each(function(){

                        if(typeof(this.id) != undefined && this.id != ""){
                            let ckId = this.id;
                            CKEDITOR.instances[ckId].setData("");
                        }
                        
                    });
                }
            });
        });


        /*Popup*/

        $(".allTickPopup").on("click", function() {
            $("#allTickPopup").modal("show");
        });

        $(".ifAnyUntickPopup").on("click", function() {
            $("#ifAnyUntickPopup").modal("show");
        });
    });
</script>

        
            