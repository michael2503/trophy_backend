<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Classes\FileUpload;

class FileManager extends Controller
{
    use ApiResponder;

    public function __construct(){
        
    }

    public function uploadProcess(Request $request, $folder, $name){
        $newname = str_replace('%20', '', $name);

        $file = $request->file('file');

        $load = FileUpload::upload($file, $folder, $newname);

        return $this->successResponse($load);
    }

}
