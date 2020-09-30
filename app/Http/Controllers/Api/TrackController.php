<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ametsuramet\StartupEngine\CoreModule;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        $data = $req->getList("location", $request->all());
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        
        $data = $req->create("location", $request->all());
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        
        $data = $req->show("location", $id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        
        $data = $req->update("location", $id, $request->all());
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $req = new CoreModule(env("STARTUP_ENGINE_APP_ID"));
        $req->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $req->setToken($request->header("token"));
        $data = $req->delete("location", $id);
        return response()->json($data);
    }

    public function taskToday(Request $request)
    {
        $req = coreModule(false);
        $input = $request->all();
        $filter = [
            [
                "type" => "and",
                "column" => "start_date",
                "notation" => ">=",
                "value" => date("Y-m-d 00:00:00"),
            ],
            [
                "type" => "and",
                "column" => "start_date",
                "notation" => "<=",
                "value" => date("Y-m-d 23:59:59"),
            ],
        ];
        $req->setToken($request->header("token"));
        $data = $req->getList("task", $input, $filter);
        return response()->json($data);
    }

    public function checkIn(Request $request)
    {
        $req = coreModule(false);
        $input = $request->all();
        $filter = [
            [
                "type" => "and",
                "column" => "date",
                "notation" => ">=",
                "value" => date("Y-m-d 00:00:00"),
            ],
            [
                "type" => "and",
                "column" => "date",
                "notation" => "<=",
                "value" => date("Y-m-d 23:59:59"),
            ],
            [
                "type" => "and",
                "column" => "type",
                "notation" => "=",
                "value" => "checkin",
            ],
        ];
        $req->setToken($request->header("token"));
        $data = $req->getList("location", $input, $filter);
        return response()->json($data);
    }

    public function checkOut(Request $request)
    {
        $req = coreModule(false);
        $input = $request->all();
        $filter = [
            [
                "type" => "and",
                "column" => "date",
                "notation" => ">=",
                "value" => date("Y-m-d 00:00:00"),
            ],
            [
                "type" => "and",
                "column" => "date",
                "notation" => "<=",
                "value" => date("Y-m-d 23:59:59"),
            ],
            [
                "type" => "and",
                "column" => "type",
                "notation" => "=",
                "value" => "checkout",
            ],
        ];
        $req->setToken($request->header("token"));
        $data = $req->getList("location", $input, $filter);
        return response()->json($data);
    }
}
