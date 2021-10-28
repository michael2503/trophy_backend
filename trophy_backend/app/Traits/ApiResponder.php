<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponder
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/
	public function successResponse($data, $code = Response::HTTP_OK)
	{
		return response()->json(['data' => $data], $code);
	}


	/**
	 * Build error response
	 * @param string/array $message
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/
	public function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}


	public function verifyPassword($password, $sqlPass){
        if(password_verify($password, $sqlPass)) {
            return true;            
        } else {           
            return false;
        }    
    }


	public function adminAuthError()
	{
		return response()->json(['error' => "Oops! This Admin is unauthorised"], 401);
	}
}