<?php

namespace App\Http\Controllers\Wms;

use App\Http\Controllers\Controller;
use App\Models\Wms\warehouseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class warehouseUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('wms_userwarehouse')
            ->join("wms_warehouse", "wms_warehouse.id", "=", "wms_userwarehouse.warehouse_id")
            ->select("wms_userwarehouse.*", "wms_warehouse.warehouse_name as warehouse_location")
            ->get();
        return response()->json($data, 200);
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
        $data = new warehouseUser;
        $request->validate([
            'user_id' => 'required',
            'user_name' => 'required',
            'is_active' => 'required',
            'warehouse_name' => 'required',
        ]);
        $data->store($request->all());
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = warehouseUser::find($id);
        return response()->json($data, 200);
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
        $data =  warehouseUser::find($id);
        $request->validate([
            'user_id' => 'required',
            'user_name' => 'required',
            'is_active' => 'required',
            'warehouse_name' => 'required',
        ]);
        $data->store($request->all());
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = warehouseUser::find($id);
        $data->delete();
        return response()->json($data, 200);
    }
}
