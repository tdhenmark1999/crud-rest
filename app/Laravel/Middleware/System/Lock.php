<?php 

namespace App\Laravel\Middleware\System;

use Closure, Session;
use Illuminate\Contracts\Auth\Guard;

class Lock {

 /**
  * The Guard implementation.
  *
  * @var Guard
  */
 protected $auth;

 /**
  * Create a new filter instance.
  *
  * @param  Guard  $auth
  * @return void
  */
 public function __construct(Guard $auth)
 {
  $this->auth = $auth;
 }

 /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */
 public function handle($request, Closure $next)
 {
  if($this->auth->user()->is_lock == "yes"){
    Session::flash('notification-status','failed');
    Session::flash('notification-title',"Alert!");
    Session::flash('notification-msg',"Account locked out due to inactivity. Please enter your password to re-enter.");
   return redirect()->guest('lock');
  }

  return $next($request);
 }

}