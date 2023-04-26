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

                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center"> <a href="#" class="mr-2 back-icon text-decoration-none border px-2 py-1 rounded"><i class="fas fa-arrow-left"></i> </a> Excel Data</h6>

                            <div class="ml-auto">
                            	
                            	
                            	<button data-toggle="modal" data-target="#excelModal" class="btn ml-auto bg-primary"> <i class="fas fa-plus"></i> Add Excel Sheet</button>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Sheet Name</th>
                                            <th>Sheet Url</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                   
                                     <tbody class="exceldatelist">
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Power of Change</td>
                                            <td class="sheeturlsec">
                                                <p> https://docs.google.com/spreadsheets/d/1v02_jEm9jmd50exUkK1kXoPbSLh--9yc_39HD2qdj5E/edit#gid=0 </p> </td>
                                            <td class="text-center">
                                              <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                              </label>
                                              <button class="btn text-danger p-0 ml-3"data-toggle="modal" data-target="#deleteuserModal"><i class="fas fa-trash"> </i></button>
                                              <button class="btn text-warning p-0 ml-3"data-toggle="modal" data-target="#excelModal"><i class="fas fa-edit"> </i></button>
                                              <a href="excel-data-view.php" class="btn text-primary p-0 ml-3"><i class="fas fa-eye"> </i></a>
                                            </td>
                                        </tr>

                                        

                                        
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
        
            