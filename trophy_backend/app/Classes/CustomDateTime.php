<?php

namespace App\Classes;

use Illuminate\Http\Response;

class CustomDateTime
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/

    public static function addDate($dateTime){
		return date('Y-m-d H:i:s', strtotime("$dateTime", strtotime(self::currentTime())));
	}	

    public static function currentDate(){
        date_default_timezone_set("Africa/Lagos");
        return date("Y-m-d");
    }

    public static function currentTime(){
        date_default_timezone_set("Africa/Lagos");
        return date("Y-m-d H:i:s");
    }

    public static function dateFrmatAlt($cDate, $alt=null){
        list($y, $m, $d) = explode("-", $cDate);

        if(checkdate($m, $d, $y)){
            $date = date_create($cDate);
            return date_format($date," M d, Y $alt");
        }else{
            return false;	
        }
    }
	

}