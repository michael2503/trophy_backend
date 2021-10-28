<?php

namespace App\Classes;



use App\Classes\Config;
use App\Classes\PHPMailer;
use App\Classes\CustomDateTime;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\WebsiteSettings;
use App\Models\Investments;

class EmailClass
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/


	public function __construct(){	
	}

	
	// EMAIL VERIFICATION EMAIL
	public static function email_verification($userInfo, $emailCode) {
		$emailContent = EmailTemplate::where('id', 4)->first();
		$fullName = $userInfo['first_name']." ".$userInfo['last_name'];
		$webSet = WebsiteSettings::first();
		$search = array('{NAME}', '{EMAIL_CODE}');
		$replace = array($fullName, $emailCode);
		$message = str_replace($search, $replace, $emailContent->content);
		$subject = $emailContent->title;
		$body = "
			<section style='background: #fff'>
			  <div style='background: #ccc; padding: 0px 5px 5px 5px'>
				<div style='background: #fff; padding-bottom: 30px'>
				  <div style='background: #000; margin: 0px 1px 0px 1px; text-align: center; padding: 6px 4px'>
					<img src='".$webSet->logo_url."' style='width: 150px'>
				  </div>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 30px'><h4 style='font-size: 17px'><b>".$subject."</b></h4></div>
				  
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 5px; color: #555'> 
					".$message."<br><br>
				  </div>
				</div>
				<div style='background: #fff; margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 14px; padding: 15px 7px; color: #777'> 
					<p style='margin: 0px'>This is an auto generated email and the mail box is not monitored. Please do not reply to this email.</p>
				  </div>
				</div>
				<div style='margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 13px; padding: 30px 5px 10px 5px; color: #444'> 
					<p style='margin: 0px'>Copyright © ".Config::project_name()." All rights Reserved. </p>
					<p style='margin: 0px'>You are receiving this email because you just registered on ".Config::project_name().". The links in this email will always direct to <b><a href='".Config::host()."' style='text-decoration: none;'>".Config::serverName()."</a></b></p>
				  </div>
				</div>
			  </div>
			</section>
		";
		$check = self::send($fullName, $userInfo['email'], $subject, $body);
		return $check;
	}


	// RESET PASSWORD EMAIL
	public static function resetPassword($userInfo, $emailCode) {
		$emailContent = EmailTemplate::where('id', 2)->first();
		$fullName = $userInfo['first_name']." ".$userInfo['last_name'];
		$webSet = WebsiteSettings::first();
		$search = array('{NAME}', '{CODE}');
		$replace = array($fullName, $emailCode);
		$message = str_replace($search, $replace, $emailContent->content);
		$subject = $emailContent->title;
		$body = "
			<section style='background: #fff'>
			  <div style='background: #ccc; padding: 0px 5px 5px 5px'>
				<div style='background: #fff; padding-bottom: 30px'>
				  <div style='background: #000; margin: 0px 1px 0px 1px; text-align: center; padding: 6px 4px'>
					<img src='".$webSet->logo_url."' style='width: 150px'>
				  </div>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 30px'><h4 style='font-size: 17px'><b>".$subject."</b></h4></div>
				  
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 5px; color: #555'> 
					".$message."<br><br>
				  </div>
				</div>
				<div style='background: #fff; margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 14px; padding: 15px 7px; color: #777'> 
					<p style='margin: 0px'>This is an auto generated email and the mail box is not monitored. Please do not reply to this email.</p>
				  </div>
				</div>
				<div style='margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 13px; padding: 30px 5px 10px 5px; color: #444'> 
					<p style='margin: 0px'>Copyright © ".Config::project_name()." All rights Reserved. </p>
					<p style='margin: 0px'>You are receiving this email because you requested to reset your password on ".Config::project_name().". The links in this email will always direct to <b><a href='".Config::host()."' style='text-decoration: none;'>".Config::serverName()."</a></b></p>
				  </div>
				</div>
			  </div>
			</section>
		";
		$check = self::send($fullName, $userInfo['email'], $subject, $body);
		return $check;
	}
	

	//CONTACT US EMAIL
	public static function guestContact($info) {
		$webSet = WebsiteSettings::first();
	
		$subject = $info['full_name'].' Contacted You';

		$body = "
			<section style='background: #fff'>
			  <div style='background: #ccc; padding: 0px 5px 5px 5px'>
				<div style='background: #fff; padding-bottom: 30px'>
				  <div style='background: #000; margin: 0px 1px 0px 1px; text-align: center; padding: 6px 4px'>
					<img src='".$webSet->logo_url."' style='width: 150px'>
				  </div>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 30px'><h4 style='font-size: 17px'><b>".$subject."</b></h4></div>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 5px; color: #555'> 
					".$info['full_name']." contact you<br>
				 	".$info['message']."<br><br>
				  </div>
				</div>
				<div style='background: #fff; margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 14px; padding: 15px 7px; color: #777'> 
					<p style='margin: 0px'>This is an email sent by a user from ".Config::project_name()."</p>
				  </div>
				</div>
				<div style='margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 13px; padding: 30px 5px 10px 5px; color: #444'> 
					<p style='margin: 0px'>Copyright © ".Config::project_name()." All rights Reserved. </p>
					<p style='margin: 0px'>You are receiving this email because a user contact you on ".Config::project_name().". The links in this email will always direct to <b><a href='".Config::host()."' style='text-decoration: none;'>".Config::serverName()."</a></b></p>
				  </div>
				</div>
			  </div>
			</section>
		";
		$check = self::sendContact($subject, $body, $info['full_name'], $info['email']);
		// return $check;
	}
	


	// SEND EMAIL
	public static function send($fullName, $email, $title, $content){
		$to = $email;
        $subject = $title;
        $message = $content;
        
        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        
        // Additional headers
        $headers[] = 'To: '.$fullName.' <'.$email.'>';
        $headers[] = 'From: '.Config::project_name().' <'.Config::siteEmail().'>';

        mail($to, $subject, $message, implode("\r\n", $headers));
	}


	// SEND EMAIL
	public static function sendContact($title, $content, $fullName, $email){
		$to = Config::siteEmail();
        $subject = $title;
        $message = $content;
        
        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        
        // Additional headers
        $headers[] = 'To: '.Config::siteEmail().' <'.Config::project_name().'>';
        $headers[] = 'From: '.$fullName.' <'.$email.'>';

        mail($to, $subject, $message, implode("\r\n", $headers));
	}





	// RESET PASSWORD EMAIL
	public static function defaultContactReply($fullName, $email) {		
		$webSet = WebsiteSettings::first();
		$message = 'Hello '.$fullName.'<br> <br>Thank you for contacting us, we have received your message and we will contact you if neccessary as soon as possible.';
		$subject = 'Thanks for contacting us';
		$body = "
			<section style='background: #fff'>
			  <div style='background: #ccc; padding: 0px 5px 5px 5px'>
				<div style='background: #fff; padding-bottom: 30px'>
				  <div style='background: #000; margin: 0px 1px 0px 1px; text-align: center; padding: 6px 4px'>
					<img src='".$webSet->logo_url."' style='width: 150px'>
				  </div>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 30px'><h4 style='font-size: 17px'><b>".$subject."</b></h4></div>
				  
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 16px; padding: 0px 5px; color: #555'> 
					".$message."<br><br>
				  </div>
				</div>
				<div style='background: #fff; margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 14px; padding: 15px 7px; color: #777'> 
					<p style='margin: 0px'>This is an auto generated email and the mail box is not monitored. Please do not reply to this email.</p>
				  </div>
				</div>
				<div style='margin-top: 2px'>
				  <div style='text-align: center; font-family: calibri, sans-serif; font-size: 13px; padding: 30px 5px 10px 5px; color: #444'> 
					<p style='margin: 0px'>Copyright © ".Config::project_name()." All rights Reserved. </p>
					<p style='margin: 0px'>You are receiving this email because you contact us on ".Config::project_name().". The links in this email will always direct to <b><a href='".Config::host()."' style='text-decoration: none;'>".Config::serverName()."</a></b></p>
				  </div>
				</div>
			  </div>
			</section>
		";
		$check = self::send($fullName, $email, $subject, $body);
		return $check;
	}

	

}