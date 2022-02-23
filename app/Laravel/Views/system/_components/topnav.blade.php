<nav class="navbar navbar-default navbar-fixed-top be-top-header">
  <div class="container-fluid">
    <div class="navbar-header"><a href="{{route('system.dashboard')}}" class="navbar-brand" style="background-image:url(https://www.monarchballroomdance.com/wp-content/uploads/2017/02/logo-placeholder.png)" ></a>
    </div>
    <div class="be-right-navbar">
      <ul class="nav navbar-nav navbar-right be-user-nav">
        <li class="dropdown">
          <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="{{$auth->avatar}}" alt="Avatar"><span class="user-name">{{$auth->name}}</span></a>
          <ul role="menu" class="dropdown-menu">
            <li>
              <div class="user-info">
                <div class="user-name">{{Helper::greet()}}, </div>
                <div class="user-name">{{$auth->name}}!</div>
              </div>
            </li>
            <li><a href="{{route('system.logout')}}"><span class="icon mdi mdi-power"></span> Logout</a></li>
          </ul>
        </li>
      </ul>
      <div class="page-title"><span style="color: #333">{{$page_title}} :: </span></div>
     
    </div>
  </div>
</nav>
