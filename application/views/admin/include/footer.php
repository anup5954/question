<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy;<?php echo date('Y'); ?> Website By Ranking. Mobile Friendly Website.</span>
                      
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <?php include('popup.php'); ?>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
    <!-- Page level custom scripts -->
    <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
    <script>
        $(document).ready( function () {
            $('#dataTableQuestion').DataTable({
               "aLengthMenu": [[100, 150, 200, 300000000], [100, 150, 200, "All"]],
            });
        });
    </script>
</body>

</html>

