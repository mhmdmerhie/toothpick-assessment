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
     *
     */
    public function outputSuccessfulApi($result) {
        return response()->json([
            'result' => $result,
        ], 200);
    }

    /**
     *
     */
    public function outputFailedApi($error_message, $status_code) {
        return response()->json([
            'message' => $error_message
        ], $status_code);
    }
}
