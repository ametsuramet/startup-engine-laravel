<?php

namespace App\Http\Controllers\Admin;

use Ametsuramet\StartupEngine\CoreModule;
use App\Classes\Model\ModelCollection;
use App\Classes\Model\TaskModel;
use App\Classes\Model\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            $data = coreModule()->getList("task", ["limit" => $limit]);
            $dataCol = new ModelCollection($data->data);
            $collection = $dataCol->transform(new TaskModel);
            // dd($collection);
            $page = $request->get('page', 1);
            $perPage = $limit;
            $paginate = new LengthAwarePaginator(
                $collection->forPage($page, $perPage),
                $data->meta->total_records,
                $perPage,
                $page,
                ['path' => url('admin/task')]
            );
            $data = coreModule()->getList("user", ["limit" => 100]);
            $dataCol = new ModelCollection($data->data);
            $collection = $dataCol->transform(new UserModel);
            $users = [];
            $collection->each(function($d, $i) use (&$users) {
                $users[$d->id] = $d->full_name;
            });
            
            
            return view('pages.task.index', ['data' => $paginate, "users" => $users]);
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
        $data = coreModule()->getList("user", ["limit" => 100]);
        $dataCol = new ModelCollection($data->data);
        $collection = $dataCol->transform(new UserModel);
        $users = [];
        $collection->each(function($d, $i) use (&$users) {
            $users[$d->id] = $d->full_name;
        });
        
        return view('pages.task.create', compact('users'));
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
            "name" => "required",
            "description" => "required",
            "created_by" => "required",
            "assigned_to" => "required",
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $input = $request->except("_token");
        $input['start_date'] = $input['start_date'].":00+07:00";

        try {
            $data = coreModule()->create("task", $input);
            return redirect(route('task.show', ['task' => $data->data->id]));
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
            $data = coreModule()->show("task", $id);
            // dd($data);
            return view('pages.task.show', ['data' => TaskModel::fromJson($data->data)]);
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
    public function addImage(Request $request, $task_id)
    {
       
        try {
            $validator = Validator::make($request->all(), [
                "path" => "required",
    
            ]);
            if ($validator->fails()) {
                if ($request->ajax()) return response()->json(['message' => $validator->errors()], 400);
                return back()->withInput()->withErrors($validator->errors());
            }
           
            $detail = coreModule()->show("task", $task_id)->data;
            $payload = [

                "name" => $detail->name,
                "description" => $detail->description,
                "created_by" => $detail->created->id,
                "assigned_to" => $detail->assigned->id,
                "images" => [[
                    "name" => "",
                    "description" => "",
                    "path" => $request->path,
                ]]
            ];

            Log::info(json_encode($payload));
    
            $data = coreModule()->update('task', $task_id, $payload);
            if ($request->ajax()) return response()->json(['message' => "success", 'data' =>$data]);
    
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
}
