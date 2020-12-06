<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class ReceiveDataController extends BaseController
{
    public function saveSensorData(Request $request, $sensor)
    {
        Log::info("saveSensorData - {$sensor}", $request->all());
    }
}
