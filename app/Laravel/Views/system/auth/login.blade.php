@extends('system._layouts.auth')

@section('content')
<div class="be-wrapper be-login">
  <div class="be-content">
    <div class="main-content container-fluid">
      <div class="splash-container">
        @include('system._components.notifications')
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading">
            <img src="https://www.monarchballroomdance.com/wp-content/uploads/2017/02/logo-placeholder.png" alt="logo" width="auto" height="90px"  class="logo-img">
            {{-- <span class="splash-description">Login to Administrator Portal</span> --}}
          </div>
          <div class="panel-body">
            <form action="" method="POST">
              {!!csrf_field()!!}
              <div class="form-group">
                <input id="username" name="username" type="text" placeholder="Username" autocomplete="off" class="form-control" value="{{old('username')}}">
              </div>
              <div class="form-group">
                <input id="password" name="password" type="password" placeholder="Password" class="form-control">
              </div>
              <div class="form-group row login-tools">
                <div class="col-xs-6 login-remember">
                  <div class="be-checkbox">
                    <input type="checkbox" id="remember" name="remember_me" value="1">
                    <label for="remember">Remember Me</label>
                  </div>
                </div>
                {{-- <div class="col-xs-6 login-forgot-password"><a href="#">Forgot Password?</a></div> --}}
              </div>
              <div class="form-group login-submit">
                <button data-dismiss="modal" type="submit" class="bg-green btn  btn-xl text-white">Sign me in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop