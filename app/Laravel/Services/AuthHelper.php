<?php

namespace App\Laravel\Services;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
	public static function isServiceDeskAdmin()
	{
		return Auth::user() 
			? in_array(Auth::user()->type, ['super_user', 'sd_admin']) 
			: false;
	}

	public static function isServiceDeskUser()
	{
		return Auth::user() 
			? in_array(Auth::user()->type, ['super_user', 'sd_admin', 'sd_manager', 'sd_supervisor', 'sd_agent']) 
			: false;
	}
}