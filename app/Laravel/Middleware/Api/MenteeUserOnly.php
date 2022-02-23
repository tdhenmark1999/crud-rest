<?php 

namespace App\Laravel\Middleware\Api;

use Closure, Session;
use Illuminate\Contracts\Auth\Guard;

class MenteeUserOnly {

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
        if ($this->auth->user()->type != 'mentee') {
            // Session::flash('notification-status','failed');
            // Session::flash('notification-msg',"You don't have enough access to the requested page.");
            // return redirect()->route('system.dashboard');
            return response()->json([
                'status' => FALSE,
                'status_code' => "PRECONDITION_FAILED",
                'hint' => "This api only works for mentee account.",
            ], 412);
        }

        return $next($request);
    }

}