<script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/chartjs/js/chart.js') }}"></script>
<script src="{{ asset('assets/backend/js/index.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIKL4_UhAFEs4fxihEqrOdj22JC3GfEgo"></script>
<script>
  $(document).ready(function() {
    $('#modalPsm').modal('show');
    $('#example').DataTable();
    } );
</script>
<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'pdf', 'print']
    } );

    table.buttons().container()
      .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script src="{{ asset('assets/backend/js/app.js') }}"></script>
<script>
  new PerfectScrollbar(".app-container")
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function(){
      $("#myform").on("submit", function(){
          $("#pageloader").fadeIn();
      });
  });
</script>
@stack('js')
