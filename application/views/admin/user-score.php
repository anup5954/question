<!--start here meta section-->
<?php include('include/meta.php'); ?>
<link rel="stylesheet" type="text/css" href="https://rettica.com/calentim/build/css/calentim.min.css">
<script type="text/javascript" src="https://rettica.com/calentim/docs/includes/scripts.min.js"></script>
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
                            <form action="" method="POST">
                        <div class="card-header py-3">
                            
                            <div class="d-flex w-100">
                            <div class="d-flex align-items-center">
                            <!-- <div class="mr-3">
                                 <label>Select Progress</label>
                                <select class="form-control">
                                    <option>Select Progress</option>
                                    <option>High</option>
                                    <option>Low</option>
                                    <option>Medium</option>
                                </select>
                            </div> -->
                            <div class="">
                                 <label>Select Categories</label>
                                <select class="form-control" id="category_name" name="category_name">
                                    <option value="">Select One</option>
                                     <?php if(!empty($cats)){ 
                                                foreach($cats as $cat){ 
                                            ?>
                                    <option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
                                    <?php } } ?>
                                    
                                </select>
                            </div>
                            <div class="ml-2 w-25">
                                <label>Point Range</label>
                                <input type="text" readonly id="cat_perce_range_from" name="cat_perce_range_from" class="form-control " style="font-size: 14px;" placeholder="From" />
                                <input type="text" readonly id="cat_perce_range_to" name="cat_perce_range_to" class="form-control " style="font-size: 14px;" placeholder="To" />
                            </div>
                            <div class="ml-2 w-25">
                                <label>Custom Date Range</label>
                                <input type="text" id="daterange" name="cat_date_range" class="form-control" style="font-size: 14px;" />
                            </div>  
                            <div class="ml-2 d-flex align-items-end " style="height:82px">
                                <button type="submit" name="searchBtn" value="searchBtn" class="btn btn-primary" style="height:50px; width:150px">Search</button>
                            </div>

                            <div class="d-flex ml-2 align-items-end " style="height:82px">
                                 <button class="btn ml-auto btn-primary mr-2"  style="height:50px;"> <i class="fa fa-download"></i></button>
                                <button class="btn ml-auto btn-primary" data-toggle="modal" data-target="#mailpopup"  style="height:50px; "> <i class="fa fa-envelope"></i></button>
                            </div>
                            </div>

                           
                            </div> 
                                                       
                        </div>
                    </form>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered userscorereport" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="sdwidth">S.No</th>
                                            <th class="sdwidth">Date</th>
                                            <th>Company Name</th>
                                            <th>User Name</th>
                                            <th>Email Id</th>
                                            <?php if(!empty($cats)){ 
                                                foreach($cats as $cat){ 
                                            ?>
                                                <th><?php echo $cat->cat_name; ?></th>
                                            <?php } } ?>
                                            <th class="sdwidth">Action</th> 
                                        </tr>
                                    </thead>
                                   
                                     <tbody>
                                        <?php if(!empty($scores)){ 
                                            foreach($scores as $score){
                                                $cat_scores = json_decode($score->cat_points)
                                        ?>
                                        <tr>
                                                <td class="text-center">01</td>
                                                <td>27 Oct 2022</td>
                                                 <td>Website By Ranking</td>
                                                <td>Anil Bhatt</td>
                                                <td>anilbhatt094@gmail.com</td>
                                                <?php foreach($cat_scores as $key => $cat_score){ ?>
                                                
                                                <td class="text-success font-weight-bold"><?php echo $cat_score ?>%</td>
                                                <?php } ?>

                                                <td class="d-flex ">
                                                    <button class="btn ml-auto bg-defult"> <i class="fa fa-download"></i> </button>
                                <button class="btn ml-auto bg-defult"> <i class="fa fa-envelope"></i> </button>
                                                </td>
                                               
                                            </tr>
                                        <?php } } ?>  
                                        

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        <!-- Content -->
        <!-- Modal -->
<div class="modal fade" id="mailpopup" tabindex="-1" role="dialog" aria-labelledby="mailpopupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mailpopupLabel">Send Mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select class="form-control mb-3">
            <option class="form-control">Select</option>
            <option class="form-control">High</option>
            <option class="form-control">Medium</option>
            <option class="form-control">Law</option>
        </select>
        <select class="form-control mb-3">
            <option>Select Categories</option>
                                    <option>Marketing</option>
                                    <option>Sales</option>
                                    <option>Marketing</option>
                                    <option>Customer Service</option>
                                    <option>Pricing Strategy</option>
                                    <option>Understanding Your Customers</option>
                                    <option>Credit Control</option>
                                    <option>Product / Service Offering</option>
                                    <option>Purchase</option>
                                    <option>Human Resources</option>
                                    <option>Operations</option>
                                    <option>Financial Performance</option>
                                    <option>Financial Stability</option>
                                    <option>Management Accounts</option>
                                    <option>IT Systems</option>
                                    <option>Management</option>
                                    <option>MIS</option>
                                    <option>Business Goals</option>
                                    <option>Your Niche</option>
                                    <option>Challenges</option>
                                    <option>Growth Potential</option>
                                    <option>Risk Management</option>
                                    <option>Key Performance Indicators</option>
                                    <option>Communication</option>
                                    <option>Strategic Business Planning</option>
                                    <option>Competition monitoring  </option>
                                    <option>Owner’s Mindset </option>
        </select>
        <textarea class="form-control" placeholder="Enter Messages" rows="5"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
               
</div>
<script type="text/javascript">
      $("#daterange").calentim({
        showTimePickers: false,
        format: "L",
        showFooter: false,
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#category_name").on("change",function(){
                if($(this).val() !== ""){
                    $("#cat_perce_range_from").prop('readonly',false);
                    $("#cat_perce_range_to").prop('readonly',false);

                } else {
                    $("#cat_perce_range_from").prop('readonly',true);
                    $("#cat_perce_range_to").prop('readonly',true);

                    $("#cat_perce_range_from").val('');
                    $("#cat_perce_range_to").val('');
                }
            })
        });
        
    </script>
<?php include('include/footer.php'); ?>
        
            