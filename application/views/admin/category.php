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
        <!--start here add categories-->
        <div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="addcategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Categories</h5>
       
      </div>
      <form class="user" action="<?php echo base_url(); ?>admin/category/create" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        


                            
                           

                            <div class="wdinput form-group">
                                <label class=" font-weight-bold">Add Category <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cat_name" placeholder="Enter Your Category" required="">
                                
                            </div>
                            <div class="wdinput form-group">
                                <label class=" font-weight-bold">Add Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="cat_description" placeholder="Enter Your Category Description" required=""></textarea> 
                            </div>

                            <div class="wdinput form-group">
                                <input type="file" name="cat_image" class="form-control" accept="image/*">
                            </div>
                          
                        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button class="btn btn-primary">Add Category</button>
      </div>
  </form>
    </div>
  </div>
</div>
<!--end here add categories-->


<!--start here edit categories-->
        <div class="modal fade" id="editcategory" tabindex="-1" role="dialog" aria-labelledby="editcategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Categories</h5>
       
      </div>
      <form class="user" action="<?php echo base_url(); ?>admin/category/update" method="post" enctype="multipart/form-data">
      <div class="modal-body">
       


                            
                           

                            <div class="wdinput form-group">
                                <label class=" font-weight-bold">Category <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="Enter Your Category" required="">
                                
                            </div>
                            <div class="wdinput form-group">
                                <label class=" font-weight-bold">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="cat_description" id="cat_description" placeholder="Enter Your Category Description" required=""></textarea> 
                            </div>

                            <div class="wdinput form-group">
                                <input type="file" name="cat_image" class="form-control" accept="image/*">
                            </div>
                          <img src="" id="displayImage" style="width:100%;">
                          <input type="hidden" name="hideImage" id="hideImage">
                          <input type="hidden" name="catId" id="catId">
                        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button class="btn btn-primary" type="submit">Update Category</button>
      </div>
  </form>
    </div>
  </div>
</div>
<!--end here edit categories-->

                <div class="container-fluid">
                    <!-- Page Heading -->
                   

                    <div class="bg-white mt-3 rounded">
                        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex">
                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center mr-auto"> Question Category</h6>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addcategory">Add Category</button>
                        </div>
                        
                    </div>
                    </div>
                </div>

                 <div class="card-body">
                    <?php show_success_msg(); ?>
                    <?php show_error_msg(); ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                   
                                     <tbody>
                                        <?php if(!empty($categories)) { 
                                            $i=1;
                                            foreach($categories as $category) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php if(!empty($category->cat_image)){ ?>
                                                <img src="<?php echo base_url(); ?>uploads/<?php echo $category->cat_image; ?>" style="height:50px;" >
                                                <?php } else { ?>
                                                    <img src="https://dummyimage.com/sqrpop" style="height:50px;" >
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <p><?php echo $category->cat_name; ?></p>
                                            </td>
                                            <td>
                                                <?php echo $category->cat_description; ?>
                                            </td>
                                            <td>
                                                <button class="btn text-warning editcategory" id="<?php echo $category->cat_id; ?>"><i class="fas fa-edit"> </i></button>
                                                <a href="<?php echo base_url('admin/category/delete/'.$category->cat_id); ?>" onClick="return confirm('Are you sure want to delete?');" class="btn text-danger"><i class="fas fa-trash"> </i></a>
                                            </td>

                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

               
        <!-- Content -->        
               
</div>

<?php include('include/footer.php'); ?>
<script>
    $(document).ready(function() {
        $(document).on("click", ".editcategory", function() {
            let catId = $(this).attr('id');
            $.ajax({
                url:"<?php echo base_url('admin/edit-catgeroy'); ?>",
                method:"POST",
                data:{"catId":catId},
                success:function(data) {
                    if(data != ""){
                        let jsonData = JSON.parse(data);
                        console.log(jsonData);
                        $("#cat_name").val(jsonData.cat_name);
                        $("#cat_description").val(jsonData.cat_description);
                        $("#hideImage").val(jsonData.cat_image);
                        $("#catId").val(jsonData.cat_id);
                        $('#displayImage').attr('src','<?php echo base_url('uploads/') ?>'+jsonData.cat_image);
                        $("#editcategory").modal("show");    
                    } else {
                        alert(data)
                    }
                            
                }
            });
            
        });
    });
</script>
        
            