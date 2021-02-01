<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\Message;
use App\Mirror;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ReceiveDataController extends BaseController
{
    public function saveSensorData(Request $request, $serial)
    {
        $mirror = Mirror::where('serial', $serial)->first();
        if ($mirror) {
            $mirror->sensorData()->where('created_at', '<=', Carbon::now()->subDays(3))->delete();
            $mirror->sensorData()->create([
                'source' => 'temp_sensor',
                'data' => $request->all()
            ]);
            return response()->json([
                'status' => 'success',
                'message' => "Data saved"
            ]);
        }
        abort(404);
    }

    public function saveCameraData(Request $request, $serial)
    {
        $mirror = Mirror::where('serial', $serial)->first();
        if ($mirror) {
            broadcast(new Message('cameraStatus', [
                'turnOff' => $request->input('turnOff')
            ], 'mirror.' . $serial));
            $mirror->sensorData()->where('created_at', '<=', Carbon::now()->subDays(3))->delete();
            $mirror->sensorData()->create([
                'source' => 'camera_sensor',
                'data' => $request->all()
            ]);
            return response()->json([
                'status' => 'success',
                'message' => "Data saved"
            ]);
        }
        abort(404);
    }
}
