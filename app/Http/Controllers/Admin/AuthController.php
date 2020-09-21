<?php

namespace App\Http\Controllers\Admin;

use Ametsuramet\StartupEngine\CoreAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Model\User;

class AuthController extends Controller
{
    
    public  function login(Request $request)
    {
        try {
            $input = $request->except('_token');
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $auth = new CoreAuth(env('STARTUP_ENGINE_APP_ID'), env('STARTUP_ENGINE_APP_KEY'));
            $auth->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
            $response = $auth->loginAdmin($input['email'], $input['password']);
            session([
                'token' => $response->token,
                'user' => $response->user,
            ]);
      
            return redirect(route('admin.dashboard'));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $resp = json_decode($e->getResponse()->getBody()->getContents());
           return back()->withInput()->withErrors(['msg' => $resp->message]);
        
        } catch (\Exception $e) {
           return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
      
    }

    public  function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('login');
    }
}
