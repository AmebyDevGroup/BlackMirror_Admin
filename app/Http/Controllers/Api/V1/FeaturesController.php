<?php

namespace App\Http\Controllers\Api\V1;

use App\Feature;
use App\Jobs\SendConfigJob;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Routing\Controller as BaseController;

class FeaturesController extends BaseController
{
    public function setFeatureActive(Feature $feature, $active = 1)
    {
        try {
            $old_active = $feature->getConfig->active;
            $feature->getConfig->update(['active' => (int)$active]);
            dispatch(new SendConfigJob(auth()->user(), 'mirror.123'));
            if ($active == 1 && $old_active != $active) {
                dispatch($feature->getJob($feature->getConfig, 'mirror.123'));
            }
            $active_message = $active?'włączony':'wyłączony';
            return response()->json([
                'success' => true,
                'message' => 'Widget został '.$active_message,
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
