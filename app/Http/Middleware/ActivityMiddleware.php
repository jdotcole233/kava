<?php

namespace App\Http\Middleware;

use App\Models\ClientActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class ActivityMiddleware
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
        if (Auth::check())
        {
            $position = Location::get("41.210.4.127");
            $path = explode(" ", $request->all()['query'])[3] ?? $request->path();
            ClientActivity::create([
                'usersuser_id' => Auth::user()->id,
                'resource_accessed' => $path,
                'ip_address' => $request->ip(),
                'device_type' => $request->userAgent(),
                'city' => $position->cityName,
                'region' => $position->regionName,
                'country' => $position->countryName,
                'country_code' => $position->countryCode,
                'lat' => $position->latitude,
                'lng' => $position->longitude,

            ]);
        }
        return $next($request);
    }
}
