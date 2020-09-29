<?php

use Ametsuramet\StartupEngine\CoreAuth;
use Ametsuramet\StartupEngine\CoreModule;
use Ametsuramet\StartupEngine\CoreMaster;
use Illuminate\Support\Carbon;

if (!function_exists('parseDate')) {
    function parseDate(String $dateString, $format = null)
    {
        $newDate = Carbon::parse($dateString);
        if ($format) $newDate = $newDate->format($format);
        return $newDate;
    }
}
if (!function_exists('coreMaster')) {
    function coreMaster($isAdmin = true) : CoreMaster
    {
        $core = new CoreMaster(
            env('STARTUP_ENGINE_APP_ID'),
            $isAdmin  ? env('STARTUP_ENGINE_APP_KEY') : null
        );
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $core->setToken(session('token'));
        return $core;
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


if (!function_exists('toSelect')) {
    function toSelect(Array $data, $id = "id", $value = "name") : Array
    {
        $response = [];
        foreach($data as $i => $d) {
            $response[$d->{$id}] = $d->{$value};
        }
        return $response;
    }
}