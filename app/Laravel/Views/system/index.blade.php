@extends('system._layouts.main')

@section('content')
<script type="text/javascript">
    window.location.href="/admin/article"
</script>
<div class="main-content container-fluid text-center">
	<img src="https://www.monarchballroomdance.com/wp-content/uploads/2017/02/logo-placeholder.png">
  <h1 style="font-size: 50px">WELCOME</h1>
 
</div>
@stop



@section('page-scripts')
<script src="{{asset('assets/lib/countup/countUp.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/jquery-flot/jquery.flot.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/jquery-flot/jquery.flot.pie.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/jquery-flot/jquery.flot.resize.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/jquery-flot/plugins/curvedLines.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/jquery-flot/jquery.flot.tooltip.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lib/chartjs/Chart.min.js')}}" type="text/javascript"></script>


<script type="text/javascript">
  $(function(){
  });
</script>
@stop