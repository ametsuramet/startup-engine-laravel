<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaskItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $task_id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "description" => "required",
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $input = $request->except("_token");
        $input['task_id'] = $task_id;
        $input['type'] = "items";
        try {
            $data = coreModule()->create("task_item", $input);
            return redirect(route('task.show', ['task' => $task_id]));
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
