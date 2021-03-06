<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use App\Helper;

class UserCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      try {
        $ip = request()->ip();
        if (! Cache::has('user-country-'.$ip)) {

          $data = Helper::getDatacURL("http://ip-api.com/json/".$ip);
          
          Cache::put('user-country-'.$ip, $data->countryCode);
        }

      } catch (\Exception $e) {}

        return $next($request);
    }
}
