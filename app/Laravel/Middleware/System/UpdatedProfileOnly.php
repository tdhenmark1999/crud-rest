<?php 

namespace App\Laravel\Middleware\System;

use Closure, Session;
use Illuminate\Contracts\Auth\Guard;

class UpdatedProfileOnly {

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
        if (strlen($this->auth->user()->email) == "0") {
            Session::flash('notification-status','warning');
            Session::flash('notification-msg',"Welcome to the Mentorme Backoffice. Please update your profile first to activate your account.");
            return redirect()->route('system.account.edit-info');
        }

        return $next($request);
    }

}