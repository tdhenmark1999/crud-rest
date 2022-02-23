<?php 

namespace App\Laravel\Middleware\System;

use Closure,Session;
use Illuminate\Contracts\Auth\Guard;

class NoClientPartner {

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
		if (in_array($this->auth->user()->type, ['client','partner'])) {
            Session::flash('notification-status','failed');
            Session::flash('notification-msg',"You don't have enough access to the requested page.");
            $this->auth->logout();
            return redirect()->route('system.login');
        }

        return $next($request);
	}

}
