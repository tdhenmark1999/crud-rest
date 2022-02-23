<script src="{{asset('assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/moment.js/min/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/daterangepicker/js/daterangepicker.js')}}" type="text/javascript"></script>
@yield('page-scripts')

<script src="{{asset('assets/js/main.js?v=1.4')}}" type="text/javascript"></script>

<script type="text/javascript">
  $(function(){
    App.init();
  	App.formElements();
  });
</script>
