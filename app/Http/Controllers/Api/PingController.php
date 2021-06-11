<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PingController extends Controller
{
    /**
     * actionPingStatus
     *
     * @param  mixed $request
     * @return response
     */
    public function actionPingStatus(Request $request)
    {
        return response()->json(api_resualt_common([
            'status'            => 'successful',
            'time_now_server'   => now()->format('H:i d/m/Y'),
            'free_disk'         => get_free_disk_root(),
            'total_disk'        => get_total_disk_root(),
            'timezone'          => config('app.timezone')
        ]), Response::HTTP_OK);
    }
}
