<?php

namespace App\Classes;

class Visitor 
{

    /**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/

	public function __construct(){
		//$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
	}

	public static function getIP(){
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		    $pattern = "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/";
		    if(preg_match($pattern, $_SERVER["HTTP_X_FORWARDED_FOR"])){
		            $userIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
		    }else{
		            $userIP = $_SERVER["REMOTE_ADDR"];
		    }
		}
		else{
		  $userIP = $_SERVER["REMOTE_ADDR"];
		}
		return $userIP;
	}

	public static function location() {	
		unset($_SESSION['gen_visitoInfo']);
		if($_SESSION['gen_visitoInfo'] == null){
			$gen_userIP = getenv('REMOTE_ADDR');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.ipdata.co/".$gen_userIP."?api-key=fe0705feb9ac669517cb73d745249c3a935ce064ad01373672233f62");
			//curl_setopt($ch, CURLOPT_URL, "https://api.ipdata.co/?api-key=fe0705feb9ac669517cb73d745249c3a935ce064ad01373672233f62");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			  "Accept: application/json"
			));

			$response = json_decode(curl_exec($ch));
			curl_close($ch);

			$locale['city'] = $response->city;
			$locale['state'] = $response->region;
			$locale['country'] = $response->country_name;
			$locale['countryCode'] = $response->country_code;
			$locale['currencyValue'] = 361;
			$_SESSION['gen_visitoInfo'] = $locale;

			//=========================================
			// set IP address and API access key 
			/*$ip = '134.201.250.155';
			$access_key = '94c8711d9eb7316c7b98c30f38ccd1f2';

			// Initialize CURL:
			$ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Store the data:
			$json = curl_exec($ch);
			curl_close($ch);

			// Decode JSON response:
			$api_result = json_decode($json, true);*/

			/*//$gen_userIP = getenv('REMOTE_ADDR');
			$gen_userIP = self::getIP();
			if(strlen($gen_userIP) < 4){
				$gen_userIP = '154.118.28.222'; //Nigeria
				//$gen_userIP = '98.172.141.125'; //US
			}

			//
			$geopluginURL= 'http://www.geoplugin.net/php.gp?ip='.$gen_userIP;
			$gen_visitoInfo = unserialize(file_get_contents($geopluginURL));			
			$locale['city'] = $gen_visitoInfo['geoplugin_city'];
			$locale['state'] = $gen_visitoInfo['geoplugin_region'];
			$locale['country'] = $gen_visitoInfo['geoplugin_countryName'];
			$locale['countryCode'] = $gen_visitoInfo['geoplugin_countryCode'];
			$locale['currencyValue'] = $gen_visitoInfo['geoplugin_currencyConverter'];
			$_SESSION['gen_visitoInfo'] = $gen_visitoInfo;*/
		}

		return $_SESSION['gen_visitoInfo'];
	}

	public static function getOS() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	   	$os_platform    =   "Unknown OS Platform";

	    $os_array = array(
	            '/windows nt 10/i'     =>  'Windows 10',
	            '/windows nt 6.3/i'     =>  'Windows 8.1',
	            '/windows nt 6.2/i'     =>  'Windows 8',
	            '/windows nt 6.1/i'     =>  'Windows 7',
	            '/windows nt 6.0/i'     =>  'Windows Vista',
	            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	            '/windows nt 5.1/i'     =>  'Windows XP',
	            '/windows xp/i'         =>  'Windows XP',
	            '/windows nt 5.0/i'     =>  'Windows 2000',
	            '/windows me/i'         =>  'Windows ME',
	            '/win98/i'              =>  'Windows 98',
	            '/win95/i'              =>  'Windows 95',
	            '/win16/i'              =>  'Windows 3.11',
	            '/macintosh|mac os x/i' =>  'Mac OS X',
	            '/mac_powerpc/i'        =>  'Mac OS 9',
	            '/linux/i'              =>  'Linux',
	            '/ubuntu/i'             =>  'Ubuntu',
	            '/iphone/i'             =>  'iPhone',
	            '/ipod/i'               =>  'iPod',
	            '/ipad/i'               =>  'iPad',
	            '/android/i'            =>  'Android',
	            '/blackberry/i'         =>  'BlackBerry',
	            '/webos/i'              =>  'Mobile'
	        );

	    foreach ($os_array as $regex => $value) { 

	        if (preg_match($regex, $user_agent)) {
	            $os_platform    =   $value;
	        }

	    }   

	    return $os_platform;
	}

	public static function getBrowser() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	   	$browser        =   "Unknown Browser";

	    $browser_array  =   array(
	            '/msie/i'       =>  'Internet Explorer',
	            '/firefox/i'    =>  'Firefox',
	            '/safari/i'     =>  'Safari',
	            '/chrome/i'     =>  'Chrome',
	            '/edge/i'       =>  'Edge',
	            '/opera/i'      =>  'Opera',
	            '/netscape/i'   =>  'Netscape',
	            '/maxthon/i'    =>  'Maxthon',
	            '/konqueror/i'  =>  'Konqueror',
	            '/mobile/i'     =>  'Handheld Browser'
	        );

	    foreach ($browser_array as $regex => $value) { 

	        if (preg_match($regex, $user_agent)) {
	            $browser    =   $value;
	        }

	    }

	    return $browser; 
	}
}

?>