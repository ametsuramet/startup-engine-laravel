<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    public  function updateProfile(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "first_name" => "required",
                // "middle_name" => "required",
                "last_name" => "required",
                "phone" => "required",
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $input = $request->except("_token");
            // dd($input);
            $core = coreModule();
            $core->setEndpoint("/api/v1/startup/user-admin/". session('user')->id);
            $data = $core->update(null, null, $input);
            session()->put('user', $data->data);
            return back();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $resp = json_decode($e->getResponse()->getBody()->getContents());
            dd($resp);
            return back()->withInput()->withErrors(['msg' => $resp->message]);
        } catch (\Exception $e) {
            dd($e);
            return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public  function profile(Request $request)
    {
        return view('pages.general.profile');
    }
}
