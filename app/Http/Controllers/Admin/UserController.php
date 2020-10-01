<?php

namespace App\Http\Controllers\Admin;

use Ametsuramet\StartupEngine\CoreModule;
use App\Classes\Model\ModelCollection;
use App\Classes\Model\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $limit;
    function __construct()
    {
        $limit = 20;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = 20;
            $req =  coreModule();
            $endpoint = "/api/v1/startup/admin/feature";
            $req->setEndpoint($endpoint);
            $data = $req->getList("user", ["limit" => $limit]);
            $dataCol = new ModelCollection($data->data);
            $collection = $dataCol->transform(new UserModel);
            // dd($collection);
            $page = $request->get('page', 1);
            $perPage = $limit;
            $paginate = new LengthAwarePaginator(
                $collection->forPage($page, $perPage),
                $data->meta->total_records,
                $perPage,
                $page,
                ['path' => url('admin/user')]
            );
            return view('pages.user.index', ['data' => $paginate]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $resp = json_decode($e->getResponse()->getBody()->getContents());
            dd($resp);
            return back()->withInput()->withErrors(['msg' => $resp->message]);
        } catch (\Exception $e) {
            dd($e);

            return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_provinces = coreMaster()->getProvince();
        $provinces = toSelect($get_provinces->data);
        $regencies = [];
        $districts = [];
        $villages = [];
        return view('pages.user.create', compact('provinces', 'regencies', 'districts', 'villages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
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

        try {
            if ($request->password != $request->confirm_password) {
                return back()->withInput()->withErrors(['msg' => "password tidak sama"]);
            }
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $input = $request->except(["_token", "_method", "confirm_password"]);
            $input["username"] = $request->email;
            $input["verify_at"] = date("Y-m-dTH:i:s+07:00");
            $req =  coreModule();
            $endpoint = "/api/v1/startup/admin/feature";
            $req->setEndpoint($endpoint);
            $data = $req->create("user", $input);
            session()->flash("success", "Data User berhasil disimpan");
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $req =  coreModule();
            $endpoint = "/api/v1/startup/admin/feature";
            $req->setEndpoint($endpoint);
            $data = $req->show("user", $id);

            return view('pages.user.show', ['data' => UserModel::fromJson($data->data)]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $resp = json_decode($e->getResponse()->getBody()->getContents());
            dd($resp);
            return back()->withInput()->withErrors(['msg' => $resp->message]);
        } catch (\Exception $e) {
            dd($e);
            return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $req =  coreModule();
            $endpoint = "/api/v1/startup/admin/feature";
            $req->setEndpoint($endpoint);
            $data = $req->show("user", $id);
            // dd($data->data);
            $get_provinces = coreMaster()->getProvince();
            $get_regencies = coreMaster()->getRegency([[
                "type" => "and",
                "column" => "province_id",
                "notation" => "=",
                "value" => $data->data->province_id,
            ]]);
            $get_districts = coreMaster()->getDistrict([[
                "type" => "and",
                "column" => "regency_id",
                "notation" => "=",
                "value" => $data->data->regency_id,
            ]]);
            $get_villages = coreMaster()->getVillage([[
                "type" => "and",
                "column" => "district_id",
                "notation" => "=",
                "value" => $data->data->district_id,
            ]]);
            $provinces = toSelect($get_provinces->data);
            $regencies = toSelect($get_regencies->data);
            $districts = toSelect($get_districts->data);
            $villages = toSelect($get_villages->data);
            // dd($provinces);
            $data = UserModel::fromJson($data->data);
            // dd($data);
            return view('pages.user.edit', compact('data', 'provinces', 'regencies', 'districts', 'villages'));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $resp = json_decode($e->getResponse()->getBody()->getContents());
            dd($resp);
            return back()->withInput()->withErrors(['msg' => $resp->message]);
        } catch (\Exception $e) {
            dd($e);
            return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
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
            $req =  coreModule();
            $endpoint = "/api/v1/startup/admin/feature";
            $req->setEndpoint($endpoint);
            $dataUser = $req->show("user", $id);
            $dataUser = json_decode(json_encode($dataUser->data), true);
            $input = $request->except(["_token", "_method"]);
            $inputUser = array_merge($dataUser, $input);

            $data = $req->update("user", $id, $inputUser);
            session()->flash("success", "Data User berhasil disimpan");
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
