<!DOCTYPE html>
<html lang="en">
  
<head>
    @include('system._components.metas')
    @include('system._components.styles')
  </head>
  <body>
    <div class="be-wrapper be-color-header be-color-header-primary">
      @include('system._components.topnav')
      @include('system._components.leftnav')
      <div class="be-content">
        @yield('content')
      </div>
      @include('system._components.rightnav')
    </div>

    @yield('page-modals')
    @include('system._components.scripts')
  </body>

</html>