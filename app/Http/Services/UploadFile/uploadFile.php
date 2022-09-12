<?php

namespace App\Http\Services\UploadFile;
use Illuminate\Support\Facades\DB;

class uploadFile{

    /**
     * Upload File
    */
    
	//Uplaod File function
    function uploadFile($file, $location){
        $file = $file;
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        //save file
        $myFileName['FileName'] = $filename;

        DB::beginTransaction();
        DB::table('upload_files')->insert($myFileName);
        DB::commit();
        
        $file->move($location, $filename);
        return $filename;
    }
}