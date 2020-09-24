<?php

use Ametsuramet\StartupEngine\CoreAuth;
use Ametsuramet\StartupEngine\CoreModule;
use Illuminate\Support\Carbon;

if (!function_exists('parseDate')) {
    function parseDate(String $dateString, $format = null)
    {
        $newDate = Carbon::parse($dateString);
        if ($format) $newDate = $newDate->format($format);
        return $newDate;
    }
}
if (!function_exists('coreModule')) {
    function coreModule($isAdmin = true) : CoreModule
    {
        $core = new CoreModule(
            env('STARTUP_ENGINE_APP_ID'),
            $isAdmin  ? env('STARTUP_ENGINE_APP_KEY') : null
        );
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $core->setToken(session('token'));
        return $core;
    }
}
if (!function_exists('coreAuth')) {
    function coreAuth($isAdmin = true) : CoreAuth
    {
        $core = new CoreAuth(
            env('STARTUP_ENGINE_APP_ID'),
            $isAdmin  ? env('STARTUP_ENGINE_APP_KEY') : null
        );
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $core->setToken(session('token'));
        return $core;
    }
}