<?php

namespace App\Http\Controllers\Wms;

use App\Http\Controllers\Controller;
use App\Models\Wms\Location;
use App\Models\Wms\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorageLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $data = Location::all();
        // return response()->json($data,200);

        $location = DB::table("wms_location")
            ->join("wms_warehouse", "wms_location.warehouse_id", "=", "wms_warehouse.id")
            ->join("wms_area", "wms_location.area_id", "=", "wms_area.id")
            ->select("wms_location.*", "wms_warehouse.warehouse_name", "wms_area.area_name")
            ->get();
        return response()->json($location, 200);
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
        $data = new Location;
        $request->validate([
            'area_id' => 'required',
            'location_code' => 'required',

            'location_name' => 'required',
            'location_type' => 'required',

            'abc_code'  => 'required',

            'capacity' => 'required',

            'drive_sequence' => 'required',

            'pick_sequence' => 'required',
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
        // $data = Location::find($id);
        $data = Location::where("uuid", $id)->get();
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
        $data = Location::find($id);
        $request->validate([
            'area_id' => 'required',
            'location_code' => 'required',
            'trace_code' => 'required',
            'location_name' => 'required',
            'location_type' => 'required',
            'size_code' => 'required',
            'abc_code'  => 'required',
            'check_digit' => 'required',
            'capacity' => 'required',
            'drive_zone' => 'required',
            'drive_sequence' => 'required',
            'pick_zone' => 'required',
            'pick_sequence' => 'required',
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
        $data = Location::find($id);
        $data->delete();
        return response()->json($data, 200);
    }
}
