<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Panoscape\Vuforia\VuforiaWebService;

class _Vuforiacontroller
{

    public function DublicateCheck($id){
        $config =  [
            "url" => [
              "targets" => "https://vws.vuforia.com/targets",
              "duplicates" => "https://vws.vuforia.com/duplicates",
              "summary" => "https://vws.vuforia.com/summary",
            ],
            "credentials" => [
              "access_key" => "c8e854315eb7569f27630668271ac23a5951d25f",
              "secret_key" => "042ed4f267edeb69756acad9b11d102681f75e96",
            ],
            "max_image_size" => 2097152,
            "max_meta_size" => 2097152,
            "naming_rule" => "/^[\w\-]+$/",
          ];
        $vws = VuforiaWebService::create($config);
        $result = $vws->getDuplicates($id);
        // if($result){
        //   echo $result['body'];
        // }
        // else{
        //   echo "not hi";
        // }
        $result = json_decode($result['body']);
        

        return $result;
    }
}
