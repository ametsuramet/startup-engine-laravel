<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ametsuramet\StartupEngine\CoreModule;

class LocationController extends Controller
{
    public function province(Request $request)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));

        $data = $req->getList("province", [
            "limit" => 100
        ]);
        return response()->json($data);
    }


    public function regency(Request $request)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        
        $filter = [[
            "type" => "and",
            "column" => "province_id",
            "notation" => "=",
            "value" => $request->get('province_id', '11'),
        ]];
        // dd($filter);
        $data = $req->getList("regency", [
            "limit" => 100,
        ], $filter);
        return response()->json($data);
    }

    public function district(Request $request)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        
        $filter = [[
            "type" => "and",
            "column" => "regency_id",
            "notation" => "=",
            "value" => $request->get('regency_id', '1101'),
        ]];
        // dd($filter);
        $data = $req->getList("district", [
            "limit" => 100,
        ], $filter);
        return response()->json($data);
    }

    public function village(Request $request)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        
        $filter = [[
            "type" => "and",
            "column" => "district_id",
            "notation" => "=",
            "value" => $request->get('district_id', '1101010'),
        ]];
        // dd($filter);
        $data = $req->getList("village", [
            "limit" => 100,
        ], $filter);
        return response()->json($data);
    }
}
