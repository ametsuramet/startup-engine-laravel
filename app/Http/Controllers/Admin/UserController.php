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
            $data = coreModule()->getList("user", ["limit" => $limit]);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            $data = coreModule()->show("user", $id);

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

            $data = coreModule()->show("user", $id);
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
            $dataUser = coreModule()->show("user", $id);
            $dataUser = json_decode(json_encode($dataUser->data), true);
            $input = $request->except(["_token", "_method"]);
            $inputUser = array_merge($dataUser, $input);
            $core = coreModule();
            $data = $core->update("user", $id, $input);
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
