<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ametsuramet\StartupEngine\CoreAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'fcm_token' => 'required',
            'device' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->getMessageBag()], 400);
        }

        $core = new CoreAuth(env("STARTUP_ENGINE_APP_ID"));
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        extract($request->all());
        $data = $core->login($username, $password, $fcm_token, $device);
        return response()->json($data);
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
            "username" => "required",
            "phone" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "gender" => "required",
            "address" => "required",
            "province_id" => "required",
            "regency_id" => "required",
            "district_id" => "required",
            "village_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->getMessageBag()], 400);
        }

        $core = new CoreAuth(env("STARTUP_ENGINE_APP_ID"));
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        extract($request->all());
        $data = $core->registration($request->all());
        return response()->json($data);
    }


    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "phone" => "required",
            "otp_number" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->getMessageBag()], 400);
        }

        $core = new CoreAuth(env("STARTUP_ENGINE_APP_ID"));
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        extract($request->all());
        $data = $core->validation($request->all());
        return response()->json($data);
    }

    public function profile(Request $request)
    {
        $core = new CoreAuth(env("STARTUP_ENGINE_APP_ID"));
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $core->setToken($request->header("token"));
        $data = $core->profile();
        return response()->json($data);
    }

    public function updateProfile(Request $request)
    {
        $core = new CoreAuth(env("STARTUP_ENGINE_APP_ID"));
        $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
        $core->setToken($request->header("token"));
        $input = $request->all();
        $data = $core->updateProfile($input);
        return response()->json($data);
    }
}
