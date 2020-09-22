<?php

namespace App\Http\Controllers\Admin;

use Ametsuramet\StartupEngine\CoreModule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskController extends Controller
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
            $core = new CoreModule(
                env('STARTUP_ENGINE_APP_ID'),
                env('STARTUP_ENGINE_APP_KEY')
            );
            $core->setBaseUrl(env("STARTUP_ENGINE_BASEURL", "http://localhost:9000"));
            $core->setToken(session('token'));
            $data = $core->getList("task", ["limit" => $limit]);
            // dd($data);
            $collection = collect($data->data);
            $page = $request->get('page', 1);
            $perPage = $limit;
            $paginate = new LengthAwarePaginator(
                $collection->forPage($page, $perPage),
                $data->meta->total_records,
                $perPage,
                $page,
                ['path' => url('admin/task')]
            );
            return view('pages.task.index', ['data' => $paginate]);
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
        //
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
        //
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
