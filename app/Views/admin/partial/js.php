<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Sweet alert and Toast -->
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
<!-- Validation -->
<script src="<?php echo base_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>

<!-- DataTables  & assets/plugins -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jszip/jszip.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/dataTables.cellEdit.js'); ?>"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- ChartJS -->
<script src="<?php echo base_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/plugins/sparklines/sparkline.js'); ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js'); ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('assets/dist/js/pages/dashboard.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/jquery.fancybox.js'); ?>"></script>

<script>
$('.iframe-btn').fancybox({  
  'width'    : 1000,
  'height'  : 100,
  'type'    : 'iframe',
    'autoScale'      : false
});

  $(function () {
    //Text Editor  
    $('.summernote').summernote()
    $('#summernote').summernote()
   
    
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    
    //Datatables  
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    
  });
 
//IMAGE PREVIEW  
function responsive_filemanager_callback(field_id){
  //var basepath = 'http://highviewsolar.com/dev';    
  var basepath = '<?php echo base_url(); ?>';    
  var url=$('#'+field_id).val();
  if(field_id=='image'){
    $(".image-preview").attr('src',basepath+'assets/admin/filemanager/plugins/source/'+url);
    $("#image-preview").attr('src',basepath+'/media/source/'+url);
    $("#div-preview").removeAttr("style");
  } else if(field_id=='banner_image') {
    $(".image-preview1").attr('src',basepath+'assets/admin/filemanager/plugins/source/'+url);
    $("#image-preview1").attr('src',basepath+'/media/source/'+url);
    $("#div-preview1").removeAttr("style");
  } else if(field_id=='menu_icon')
    $(".image-preview2").attr('src',basepath+'assets/admin/filemanager/plugins/source/'+url);
    $("#image-preview2").attr('src',basepath+'/media/source/'+url);
    $("#div-preview2").removeAttr("style");
}
</script>