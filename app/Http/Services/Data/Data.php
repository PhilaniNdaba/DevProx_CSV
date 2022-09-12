<?php

namespace App\Http\Services\Data;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Services\GenerateCSV\CSV;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Data{

    /**
     * Data constructor
     */
    //Save Data
    function SaveData($request){
        ini_set('max_execution_time', 300);
        try{
            $variationNumber = $request->variationNumber;

            $headers = array("id", "Name", "Surname", "Initials", "Age", "DateOfBirth");

            $names = array("Andre", "Tyron", "Philani", "John", "Mark", "Travor", "Sizwe", "James", "Patros", "David", "Muzi", "Lashely", "Dumisani", "Nomasonto", "Jabulile", "Nash", "Elon", "Nomfundo", "Zack", "Dudu"); 
            $surnames = array("Ndaba", "Kubheka", "Smith", "Brown", "Musk", "Noah", "Wilson", "Khumalo", "Mabaso", "Stewart", "Mlaba", "Scott", "Campbell", "Walker", "Robinson", "Zwane", "Miller", "Fraser", "Clark", "Zungu");

            $fh = fopen("output.csv", "w");

            fputcsv($fh, $headers);

            for($i = 0; $i < $variationNumber; $i++){
                // $id = 0;
                $day = rand(1, 31);
                $month = rand(1, 12);
                $year = rand(1980, 2020);

                if($day < 10){
                    $day = '0'.$day;
                }
                if($month < 10)
                    $month = '0'.$month;

                //DOB
                $DOB = $day.'/'.$month.'/'.$year;

                //Age
                $age = date('Y') - $year;

                //Set Name
                // for($x = 0; $x < 20; $x++){
                    $rand = rand(1, 2);

                    $nameVar = '';
                    $surnameVar = '';
                    $initialsVar = '';

                    for($j = 0; $j < $rand; $j++){
                        $arrayNum = rand(0, 19);

                        $nameVar .= $names[$arrayNum].' ';
                        $initialsVar .= substr($names[$arrayNum], 0, 1).' ';
                    }

                    for($j = 0; $j < $rand; $j++){
                        $arrayNum = rand(0, 19);
                        $surnameVar .= $surnames[$arrayNum].' ';
                    }

                    $data = array(
                        "id" => 0,
                        "Name" => $nameVar,
                        "Surname" => $surnameVar,
                        "Initials" => $initialsVar,
                        "Age" => $age,
                        "DateOfBirth" => $DOB
                    );

                    $validateData = Validator::make($data, [
                        "Name" => 'unique:csv_import',
                        "Surname" => 'unique:csv_import',
                        "Initials" => 'unique:csv_import',
                        "Age" => 'unique:csv_import',
                        "DateOfBirth" => 'unique:csv_import'
                    ]);
                    if($validateData->fails()){
                        $nameVar = '';
                        $surnameVar = '';
                        $initialsVar = '';

                        for($j = 0; $j < 3; $j++){
                            $arrayNum = rand(0, 19);
    
                            $nameVar .= $names[$arrayNum].' ';
                            $initialsVar .= substr($names[$arrayNum], 0, 1).' ';
                        }
    
                        for($j = 0; $j < 2; $j++){
                            $arrayNum = rand(0, 19);
                            $surnameVar .= $surnames[$arrayNum].' ';
                        }

                        $data['Name'] = $nameVar.$i;
                        $data['Surname'] = $surnameVar.$i;
                        $data['Initials'] = $initialsVar.$i;
                        $data['Age'] = $age . $i;
                        $data['DateOfBirth'] = $day.'/'.$month.'/'.$year . $i;

                        $validateData = Validator::make($data, [
                            "Name" => 'unique:csv_import',
                            "Surname" => 'unique:csv_import',
                            "Initials" => 'unique:csv_import',
                            "Age" => 'unique:csv_import',
                            "DateOfBirth" => 'unique:csv_import'
                        ]);

                        if(!$validateData->fails()){
                            DB::beginTransaction();
                            $id = DB::table('csv_import')->insertGetId($data);
                            DB::commit();
                        }
                    }
                    else{
                        DB::beginTransaction();
                        $id = DB::table('csv_import')->insertGetId($data);
                        DB::commit();
                    }
                    
                    $data['id'] = $id;

                    fputcsv($fh, $data);
                // }
            }

            fclose($fh);

            return response()->json(['status' => 'success']);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => 'Failed to generate CSV', 'error' => $e->getMessage()]);
        }
    }
}
