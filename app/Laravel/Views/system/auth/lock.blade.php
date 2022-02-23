@extends('system._layouts.auth')

@section('content')
<div class="be-wrapper be-login">

  <div class="be-content">

    <div class="main-content container-fluid">
      <div class="splash-container">
        @include('system._components.notifications')
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading"><img src="{{asset('logo.png')}}" alt="logo" width="102" height="102" class="logo-img">
            <h4>Hi <strong>{{$auth->name}}</strong>!</h4>
          </div>
          <div class="panel-body">
            
            <form action="" method="POST">
              {!!csrf_field()!!}
              <div class="form-group">
                <label for="password">Enter your password to access the system.</label>
                <input id="password" name="password" type="password" placeholder="Password" class="form-control">
              </div>
              <div class="form-group row login-tools">
                <div class="col-xs-12 login-remember">
                  <a href="{{route('system.logout')}}">Not you? Login you account.</a>
                </div>
              </div>
              <div class="form-group login-submit">
                <button data-dismiss="modal" type="submit" class="btn btn-warning btn-xl">Unlock</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop