<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Data\Data;
use App\Http\Services\UploadFile\UploadFile;

class CSVController extends Controller
{
    //Create CSV
    function SaveData(Request $request){
        try{
            $saveData = new Data();

            return $saveData->SaveData($request);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error', 'error' => $e->getMessage()]);
        }
    }

    //Upload File
    function Uploadfile(Request $request){
        try{
            $uploadFile = new uploadFile();

            return $uploadFile->uploadFile($request->myFile, 'files');
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error', 'error' => $e->getMessage()]);
        }
    }
}
