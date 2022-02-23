@extends('system._layouts.auth')

@section('content')
<div class="be-wrapper be-login">
  <div class="be-content">
    <div class="main-content container-fluid">
      <div class="splash-container">
        @include('system._components.notifications')
        <div class="panel panel-default panel-border-color panel-border-color-warning">
          <div class="panel-heading"><img src="{{asset('logo.png')}}" alt="logo" width="102" height="102" class="logo-img"><span class="splash-description">This is intended for all <strong>interns</strong> that doesn't have an account yet. <strong class="text-danger">Don't spread this link to avoid any consequences.</strong></span></div>
          <div class="panel-body">
            <form action="" method="POST">
              {!!csrf_field()!!}
              <div class="form-group">
                <input id="name" name="name" type="text" placeholder="Your Name" autocomplete="off" class="form-control" value="{{old('name')}}">
              </div>
              <div class="form-group">
                <input id="position" name="position" type="text" placeholder="Assigned Position, eg. GFX, Intern" autocomplete="off" class="form-control" value="{{old('position')}}">
              </div>
              <div class="form-group">
                <input id="username" name="username" type="text" placeholder="Username" autocomplete="off" class="form-control" value="{{old('username')}}">
              </div>
              <div class="form-group">
                <input id="email" name="email" type="text" placeholder="Email Address" autocomplete="off" class="form-control" value="{{old('email')}}">
              </div>
              <div class="form-group">
                <input id="password" name="password" type="password" placeholder="Password" class="form-control">
              </div>
              <div class="form-group">
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Verify Password" class="form-control">
              </div>
              <div class="form-group row login-tools">
                <div class="col-xs-6 login-remember">
                  <div class="be-checkbox">
                    <input type="checkbox" id="remember" name="auto_login" value="1" {{old('auto_login',1) == "1" ? 'checked="checked"' : NULL}}>
                    <label for="remember">Auto Login</label>
                  </div>
                </div>
                {{-- <div class="col-xs-6 login-forgot-password"><a href="#">Forgot Password?</a></div> --}}
              </div>
              <div class="form-group login-submit">
                <button data-dismiss="modal" type="submit" class="btn btn-warning btn-xl">Register Account</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop