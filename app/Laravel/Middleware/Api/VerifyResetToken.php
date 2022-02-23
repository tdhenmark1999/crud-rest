<?php

namespace App\Laravel\Middleware\Api;

use Carbon, Closure, DB, Helper,Str;

class VerifyResetToken
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $validation_token = Str::lower($request->get('validation_token'));
        $email = Str::lower($request->get('email'));

        $token = DB::table('password_resets')
                    ->whereRaw("LOWER(email) = '{$email}'")
                    ->whereRaw("LOWER(token) = '{$validation_token}'")
                    ->orderBy("created_at","DESC")
                    ->first();

        if(!$token) {
        	return response()->json([
                'msg' => "Invalid reset token.",
                'status' => FALSE,
                'status_code' => "INVALID_RESET_TOKEN",
            ], 421);
        }

        if(Carbon::parse($token->created_at)->addMinutes(60)->isPast()) {
        	return response()->json([
                'msg' => "Invalid reset token.",
                'status' => FALSE,
                'status_code' => "INVALID_RESET_TOKEN",
            ], 421);
        }

        return $next($request);
    }
}
