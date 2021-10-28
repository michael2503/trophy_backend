<?php

namespace App\Classes;

use App\Classes\Settings;
use App\Classes\Config;

class FileUpload
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/

	public static function upload($file, $folder, $name){
        if ($file) {
            $original_filename = $file->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);

            $file_ext = end($original_filename_arr);
            $destination_path = $_SERVER["DOCUMENT_ROOT"].'/upload/'.$folder;

            $fileName = $name.Settings::randomStrgs(5) . '.' . $file_ext;

            $send = $file->move($destination_path, $fileName);

            if ($send) {
                return Config::host().'/upload/'. $folder . '/' . $fileName;
            } else {
                return 'Error';
            }
        } else {
            return 'Error';
        }
    }
	

}