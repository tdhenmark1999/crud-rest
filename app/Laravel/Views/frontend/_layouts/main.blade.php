<!DOCTYPE html>
<html>
<head>
	@include('frontend._components.metas')
	@include('frontend._components.styles')
	@yield('page-styles')
</head>

<body>	
		@yield('content')

@include('frontend._components.scripts')
@yield('page-scripts')
</body>
</html>