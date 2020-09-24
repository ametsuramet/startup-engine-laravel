<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.dashboard');
    }
    public function upload(Request $request)
    {
        $multipart = [
            [
                'name'     => 'file',
                'contents' => fopen($request->file('file')->path(), 'r')
            ]
        ];
        $response = coreAuth()->upload($multipart);
        return response()->json($response);
    }
}
