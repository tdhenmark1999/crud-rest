<?php

namespace App\Laravel\Services;

use Illuminate\Support\Facades\Cache;
use Carbon, Str,Route;

class Helper {

	public static function is_active(array $routes, $class = "active") {
		return  in_array(Route::currentRouteName(), $routes) ? $class : NULL;
	}
	

	public static function date_format($time,$format = "m/d/Y @ h:i A") {
		return $time == "0000-00-00 00:00:00" ? "" : date($format,strtotime($time));
	}

	public static function int_to_month($m = 0, $format = "F") {
		return Carbon::createFromFormat("!m", $m)->format($format);
	}

	/**
	 * Parse date to the 'date only' format
	 *
	 * @param date $time
	 * @param string $format
	 *
	 * @return Date
	 */
	public static function date_only($time) {
		return Self::date_format($time, "m/d/Y");
	}

	public static function time_only($time) {
		return Self::date_format($time, "h:i A");
	}

	public static function nice_number($number,$sepator = ","){
		return number_format($number,0,"",$sepator);
	}


	public static function amount($number,$sepator = ","){
		return number_format($number,2,".",$sepator);
	}

	public static function crypto_amount($number){
		return number_format($number,8,".",",");
	}

	/**
	 * Parse date to a greeting
	 *
	 * @param date $time
	 *
	 * @return string
	 */
	public static function greet($time = NULL) {
		if(!$time) $time = Carbon::now();
		$hour = date("G",strtotime($time));
		
		if($hour < 5) {
			$greeting = "You woke up early";
		}elseif($hour < 10){
			$greeting = "Good morning";
		}elseif($hour <= 12){
			$greeting = "It's almost lunch";
		}elseif($hour < 18){
			$greeting = "Good afternoon";
		}elseif($hour <= 22){
			$greeting = "Good evening";
		}else{
			$greeting = "You must be working really hard";
		}

		return $greeting;
	}

	public static function time_passed($time){
		$date = Carbon::parse($time);

    	if($date->format("Y-m-d") == Carbon::now()->format("Y-m-d")) {
    		return "Today " . $date->format("h:i a");
    	} elseif ($date->between(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek())) {
    		// return $date->format("D h:i a");
    		return $date->format("D")." at ".$date->format("h:i a");
    	} elseif ($date->format("Y") == Carbon::now()->format("Y")) {
    		return $date->format("d/M")." at ".$date->format("h:i a");
    	} else {
    		return $date->format("d/M Y")." at ".$date->format("h:i a");
    	}
	}

	public static function birthdate($time, $format = "l F d") {
		$current_year = Carbon::now()->format("Y");
		$upcoming_birthdate = Carbon::parse("{$current_year}-".Carbon::parse($time)->format("m-d"));
		if($upcoming_birthdate->isPast()) {
			$upcoming_birthdate->addYear();
		}
		return $upcoming_birthdate->format($format);
	}

	public static function month_year($time){
		return date('M Y',strtotime($time));
	}

	public static function date_db($time){
		if(env('DB_CONNECTION','mysql') == "sqlsrv"){
			return date(env('DATEDBSQL_FORMAT','m/d/Y'),strtotime($time));
		}else{
			return date(env('DATEDB_FORMAT','Y-m-d'),strtotime($time));
		}
	}

	public static function datetime_db($time){
		if(env('DB_CONNECTION','mysql') == "sqlsrv"){
			return date(env('DATEDBSQL_FORMAT','m/d/Y H:i:s'),strtotime($time));
		}else{
			return date(env('DATEDB_FORMAT','Y-m-d H:i:s'),strtotime($time));
		}
	}

	public static function create_filename($ext) {
		return Str::lower(str_random(10). date("Hi")) . "." . $ext;
	}

	public static function create_username($name, $counter = 0) {
		return $counter > 0 ? substr(Str::slug($name,""), 0, 19) . ++$counter : substr(Str::slug($name,""), 0, 20);
	}

	public static function str_contract($str) {
		return in_array(substr($str, -1), ['s', "S"]) ? $str . "'" : $str . "'s";
	}

	public static function key_prefix($prefix, array $array = []) {
		foreach($array as $k=>$v){
            $array[$prefix.$k] = $v;
            unset($array[$k]);
        }
        return $array; 
	}

	public static function mask_urls($str, $replace = "{link}") {
		$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		return preg_replace($pattern, $replace, $str);
	}

	public static function clean_url($url) {


		// multiple /// messes up parse_url, replace 2+ with 2
		$url = preg_replace('/(\/{2,})/','//',$url);

		$parse_url = parse_url($url);

		if(empty($parse_url["scheme"])) {
		    $parse_url["scheme"] = "http";
		}
		if(empty($parse_url["host"]) && !empty($parse_url["path"])) {
		    // Strip slash from the beginning of path
		    $parse_url["host"] = ltrim($parse_url["path"], '\/');
		    $parse_url["path"] = "";
		}   

		$return_url = "";

		// Check if scheme is correct
		if(!in_array($parse_url["scheme"], array("http", "https", "gopher"))) {
		    $return_url .= 'http'.'://';
		} else {
		    $return_url .= $parse_url["scheme"].'://';
		}

		// Check if the right amount of "www" is set.
		$explode_host = explode(".", $parse_url["host"]);

		// Remove empty entries
		$explode_host = array_filter($explode_host);
		// And reassign indexes
		$explode_host = array_values($explode_host);

		// Contains subdomain
		if(count($explode_host) > 2) {
		    // Check if subdomain only contains the letter w(then not any other subdomain).
		    if(substr_count($explode_host[0], 'w') == strlen($explode_host[0])) {
		        // Replace with "www" to avoid "ww" or "wwww", etc.
		        $explode_host[0] = "www";

		    }
		}

		$return_url .= implode(".",$explode_host);

		if(!empty($parse_url["port"])) {
		    $return_url .= ":".$parse_url["port"];
		}
		if(!empty($parse_url["path"])) {
		    $return_url .= $parse_url["path"];
		}
		if(!empty($parse_url["query"])) {
		    $return_url .= '?'.$parse_url["query"];
		}
		if(!empty($parse_url["fragment"])) {
		    $return_url .= '#'.$parse_url["fragment"];
		}

		return $return_url;
	}

	// public static function get_response_message($code, array $vars = []) {
	// 	$1= "";
	// 	// $response_message = Cache::remember($code . implode(".", $vars), 1440, function() use($code) {
	// 	// 	return ResponseMessage::where('code', $code)->first();
	// 	// });
	// 	$response_message = ResponseMessage::where('code', $code)->first();
		
	// 	if($response_message) {
	// 		$response = $response_message->content;
	// 		foreach ($vars as $key => $value) {
	// 			$response = str_replace('{'.strtolower($key).'}', $value, $response);
	// 		}
	// 	}
	// 	return $response;
	// }

	public static function status_badge($type){
		$result = "default";
		switch(Str::lower($type)){
			case 'inactive': $result = "warning"; break;
			case 'active':
			case 'yes': $result = "success"; break;
		}
		return $result;
	}

	public static function transaction_badge($type){
		$result = "default";
		switch(Str::lower($type)){
			case 'ongoing': $result = "warning"; break;
			case 'delivered': $result = "success"; break;
		}


		return $result;
	}

	public static function account_type($type){
		$result = "default";
		switch(Str::lower($type)){
			case 'mentee': $result = "default"; break;
			case 'mentor': $result = "success"; break;
		}
		return $result;
	}

	public static function format_num($n) {
	    $s = array("K", "M", "B", "T");
	    $out = "";
	    while ($n >= 1000 && count($s) > 0) {
	        $n = $n / 1000.0;
	        $out = array_shift($s);
	    }
	    return round($n, max(0, 3 - strlen((int)$n))) ."$out";
	}

	public static function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}

	public static function curl_get_file_size( $url ) {
	  // Assume failure.
	  $result = -1;

	  $curl = curl_init( $url );

	  // Issue a HEAD request and follow any redirects.
	  curl_setopt( $curl, CURLOPT_NOBODY, true );
	  curl_setopt( $curl, CURLOPT_HEADER, true );
	  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	  curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
	  // curl_setopt( $curl, CURLOPT_USERAGENT, get_user_agent_string() );

	  $data = curl_exec( $curl );
	  curl_close( $curl );

	  if( $data ) {
	    $content_length = "unknown";
	    $status = "unknown";

	    if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
	      $status = (int)$matches[1];
	    }

	    if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
	      $content_length = (int)$matches[1];
	    }

	    // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	    if( $status == 200 || ($status > 300 && $status <= 308) ) {
	      $result = $content_length;
	    }
	  }

	  return $result;
	}

	public static function compute_time($received_date , $delivery_date,$status){

		if(!$delivery_date OR $status != "delivered"){
			$delivery_date = self::date_db(Carbon::now());
		}


		return (strtotime($delivery_date) - strtotime($received_date))/60;
	}

	public static function mins_to_time($mins) {
		$seconds = $mins * 60;
	    $dtF = new \DateTime('@0');
	    $dtT = new \DateTime("@$seconds");
	     // %iM
	    return $dtF->diff($dtT)->format('%aD %hH');
	}

}