<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyDeviceToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $deviceID = $request->header('device_id');
        $deviceToken = $request->header('device_token');
        $deviceType = $request->header('device_type');
        $userID = auth()->id(); // Assuming you have authentication

        $existingDevice = Device::where('device_id', $deviceID)->where('user_id', $userID)->first();
        
        if ($existingDevice) {
            if ($existingDevice->device_token !== $deviceToken) {
                $existingDevice->device_token = $deviceToken;
                $existingDevice->deviceType = $deviceType;
                $existingDevice->save();
            }
        } else {
            Device::create([
                'user_id' => $userID,
                'device_id' => $deviceID,
                'device_token' => $deviceToken,
                'device_type' => $deviceType,
            ]);
        }

        return $next($request);
    }
}



