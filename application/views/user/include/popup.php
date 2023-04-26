<!--logout popup-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo base_url('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!--logout popup-->


    <!--Delete Question popup-->
<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are You Sure Delete Question</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

               
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="" target="_self">Ok</a>
                </div>
            </div>
        </div>
    </div>
     <!--Delete Question popup-->

      <!--Delete User popup-->
<div class="modal fade" id="deleteuserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are You Sure Delete User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

               
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="" target="_self">Ok</a>
                </div>
            </div>
        </div>
    </div>
     <!--Delete user popup-->


<!--Edit User popup-->
<div class="modal fade" id="edituserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                 <div class="modal-body">
                    <form>
                        <div class="form-group">
                        <input type="text" name="fname" class="form-control" placeholder="Full Name">
                        </div>

                        <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email Id">
                        </div>

                        <div class="form-group">
                        <input type="number" name="email" class="form-control" placeholder="Phone Number">
                        </div>

                        <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Create Password">
                        </div>

                    </form>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="" target="_self">Update User</a>
                </div>
            </div>
        </div>
    </div>
     <!--Edit user popup-->

     <!--Add User popup-->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                 <div class="modal-body">
                    <form>
                        <div class="form-group">
                        <input type="text" name="fname" class="form-control" placeholder="Full Name">
                        </div>

                        <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email Id">
                        </div>

                        <div class="form-group">
                        <input type="number" name="email" class="form-control" placeholder="Phone Number">
                        </div>

                        <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Create Password">
                        </div>

                        <div class="form-group">
                        <input type="text" name="amount" class="form-control" placeholder="Enter minimum amount Rs200">
                        </div>

                    </form>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="" target="_self">Pay Amoun</a>
                </div>
            </div>
        </div>
    </div>
     <!--Add user popup-->




     <!--Excel sheet popup-->
<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Excel Sheet</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                 <div class="modal-body">
                    <form>
                        <div class="form-group">
                        <input type="text" name="sheetname" class="form-control" placeholder="Sheet Name">
                        </div>

                         <div class="form-group">
                        <input type="text" name="sheeturl" class="form-control" placeholder="Sheet Url">
                        </div>                   

                        

                       

                       

                    </form>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="" target="_self">Add</a>
                </div>
            </div>
        </div>
    </div>
     <!--Excel sheet add popup-->