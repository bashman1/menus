<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //


    public function genericResponse($status, $message, $code, $data){
        return response()->json([
            "status"=>$status,
            "code"=>$code,
            "message"=>$message,
            "data"=>$data
        ]);
    }
}
