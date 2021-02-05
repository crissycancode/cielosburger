
<!-- jQuery 3 -->
 <script src="assets/bower_components/jquery/dist/jquery.min.js"></script> 

<!-- Bootstrap 3.3.7 -->
 <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

<!-- Select2 -->
 <script src="assets/bower_components/select2/dist/js/select2.full.min.js"></script> 

<!-- InputMask -->
<script src="assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="assets/bower_components/moment/min/moment.min.js"></script>
<script src="assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<!--<script src="assets./bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>-->
<!-- bootstrap color picker -->
<script src="assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>




<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "paging": true,
        "searching": true,
        // "lengthChange": true,
        "ordering": true,
        "autoWidth": true
      });
      $('#example2').DataTable({
          "paging": false,
          "searching": false,
        //   "lengthChange": true,
          "ordering": false,
          "autoWidth": true,
          "info": true
      });
      $('#example3').DataTable({
          "paging": false,
          "searching": true,
        //   "lengthChange": true,
          "ordering": true,
          "autoWidth": true,
          "info": true
      });
      $('#modalTable').DataTable({
          "paging": true,
          "searching": false,
        //   "lengthChange": true,
          "ordering": false,
          "autoWidth": true,
          "info": true
      });
    });
</script>

</body>
</html>