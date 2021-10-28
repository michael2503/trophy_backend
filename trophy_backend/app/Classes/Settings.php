<?php

namespace App\Classes;



class Settings
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/

	public static function randomStrgs($length){
		$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$clen   = strlen($chars)-1;
		$randmStr  = '';

		for ($i = 0; $i < $length; $i++) {
		      $randmStr .= $chars[mt_rand(0,$clen)];
		}
		return strtoupper($randmStr);
	}

	public static function cleanUrl($string) {
		$string = str_replace('.', 'dot ', $string);
		$firt = substr($string,0,1);
		if($firt == " ") {
		  $string = preg_replace("/^".$firt."/", "", $string);
		}else{
		  $string = $string;
		}

		$string = str_replace(' - ', ' ', rtrim(trim($string), ' '));

		   $string = str_replace(' ', '-', str_replace('&', 'and', str_replace('  ', ' ', $string)));

		   return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $string));
	}

	public static function randomStrgsUpperLower($length){
		$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$clen   = strlen($chars)-1;
		$randmStr  = '';

		for ($i = 0; $i < $length; $i++) {
		      $randmStr .= $chars[mt_rand(0,$clen)];
		}
		return $randmStr;
	}

	public static function randomNumber($length){
		$chars = "1234567890";
		// $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$clen   = strlen($chars)-1;
		$randmStr  = '';

		for ($i = 0; $i < $length; $i++) {
		      $randmStr .= $chars[mt_rand(0,$clen)];
		}
		return strtoupper($randmStr);
	}
	

}