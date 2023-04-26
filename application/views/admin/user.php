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

                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center"> Users</h6>

                            <div class="ml-auto">
                            	<button class="btn ml-auto bg-defult"> <i class="fas fa-file-export"></i> Export</button>
                            	
                            	<!-- <button data-toggle="modal" data-target="#userModal" class="btn ml-auto bg-primary"> <i class="fas fa-plus"></i> Add User</button> -->
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email Id</th>
                                            <th>Phone number</th>
                                            <th>Report</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                   
                                     <tbody>
                                        <?php if(!empty($users)){
                                            $sno = 1; 
                                            foreach($users as $user){
                                            ?>
                                        <tr>
                                                <td class="text-center"><?php echo $sno++; ?></td>
                                                <td><?php echo $user->firstname.' '.$user->lastname; ?></td>
                                                <td><?php echo $user->email; ?></td>
                                                <td><?php echo $user->mobile; ?></td>
                                                <?php if(!empty($user->report_generated)) { ?>
                                                    <td><a href="<?php echo base_url('uploads/'.$user->report_link); ?>" class="text-decoration-none text-success" target="_blank"> <i class="fa fa-download mr-2"> </i> Complete  </a></td>
                                                <?php } else { ?>
                                                    <td><a href="javascript:void(0)" class="text-decoration-none text-warning" disable>Pending </a></td>
                                                <?php } ?>
                                                <td class="text-center">
                                                  <label class="switch">
                                                    <input type="checkbox" class="user_status" id="<?php echo $user->id; ?>" <?php echo ($user->status == 1)?'checked':''; ?>>
                                                    <span class="slider round"></span>
                                                  </label>
                                                  <!-- <button class="btn text-danger p-0 ml-3"data-toggle="modal" data-target="#deleteuserModal"><i class="fas fa-trash"> </i></button> -->
                                                  <!-- <button class="btn text-warning p-0 ml-3"data-toggle="modal" data-target="#edituserModal"><i class="fas fa-edit"> </i></button> -->
                                                </td>
                                            </tr>
                                        <?php }}?> 
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

<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('change','.user_status',function(){

            var userId = $(this).attr('id');

            var status = 0;

            if($(this).is(":checked")){
                status = 1;
            }

            if(userId != "" && userId != undefined){
                $.ajax({
                    url: "<?php echo base_url('admin/user/changeStatus'); ?>",
                    method: 'POST',
                    data: {'userId' : userId, 'status': status},
                    success: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });
</script>
        
            