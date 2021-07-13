<?php

namespace App\Http\Controllers\Wms;

use App\Http\Controllers\Controller;
use App\Models\Wms\ItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table("wms_itemmaster")
            ->join("wms_dropdown", "wms_dropdown.identity_code", "=", "wms_itemmaster.abccode")
            ->select("wms_itemmaster.*", "wms_dropdown.description")
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
        $data = new ItemMaster;
        $request->validate([
            'storageclass_id' => 'required',
            'itemcode' => 'required',
            'description' => 'required',
            'handlingunit' => 'required',
            'abccode' => 'required',
            'unitcost' => 'required',
            'safestocklevel' => 'required',
            'shelflifeunit' => 'required',
            'salvagedays' => 'required',
            'stockrestriction' => 'required',
            'lotformat' => 'required',
            'lotformatdate' => 'required',
            'batchfindstrategy' => 'required',
            'unitqtyperbatch' => 'required',
            'eachuom' => 'required', 'max:20',
            'eachqtyperhandlingunit' => 'required',
            'unitvolume' => 'required',
            'unitweight' => 'required',
            'minreplenishmentlvl' => 'required',
            'maxreplenishmentqty' => 'required',
            'eachreplenishmentlvl' => 'required',
            'eachhureplenishmentqty' => 'required',
            'isbatchmanaged' => 'required',
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
        $data = DB::table("wms_itemmaster")
            ->join("wms_dropdown", "wms_dropdown.identity_code", "=", "wms_itemmaster.abccode")
            ->select("wms_itemmaster.*", "wms_dropdown.description")
            ->where("wms_itemmaster.uuid", $id)
            ->get();
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
        $data =  ItemMaster::find($id);
        $request->validate([
            'storageclass_id' => 'required',
            'itemcode' => 'required',
            'description' => 'required',
            'handlingunit' => 'required',
            'abccode' => 'required',
            'unitcost' => 'required',
            'safestocklevel' => 'required',
            'shelflifeunit' => 'required',
            'salvagedays' => 'required',
            'stockrestriction' => 'required',
            'lotformat' => 'required',
            'lotformatdate' => 'required',
            'batchfindstrategy' => 'required',
            'unitqtyperbatch' => 'required',
            'eachuom' => 'required', 'max:20',
            'eachqtyperhandlingunit' => 'required',
            'unitvolume' => 'required',
            'unitweight' => 'required',
            'minreplenishmentlvl' => 'required',
            'maxreplenishmentqty' => 'required',
            'eachreplenishmentlvl' => 'required',
            'eachhureplenishmentqty' => 'required',
            'isbatchmanaged' => 'required',
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
        $data =  ItemMaster::find($id);
        $data->delete();
        return response($data, 200);
    }
}
