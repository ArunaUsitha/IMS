<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @param $status
     * @param $errorType
     * @param $message
     * @param $data
     * @return array
     * error type = toast/header
     */
    static function getJSONResponse($status, $errorType, $message,$data){

        return [
            'status' => $status,
            'error_type' => $errorType,
            'message' => $message,
            'data' => $data
        ];

    }
}
