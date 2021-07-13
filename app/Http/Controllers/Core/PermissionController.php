<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Menu;
use App\Models\Core\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    function index()
    {

        return view("core.permision", []);
    }

    function permissionlist()
    {
        $data = DB::table("core_menu")
            ->join("core_permission", "core_menu.id", "=", "core_permission.menu_id")
            ->select("core_menu.menu_title", "core_permission.*")
            ->get();
        return response()->json($data, 200);
    }
    function menulist()
    {
        $data = Menu::select('id', 'menu_title')->get();
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $data = new Permission();
        $request->validate([
            'menu_id' => 'required',
            'description' => 'required',
        ]);
        $data->store($request->all());
        return response()->json($data, 200);
    }



    public function update(Request $request, $id)
    {
        $data =  Permission::find($id);
        $request->validate([
            'menu_id' => 'required',
            'description' => 'required',
        ]);


        $data->store($request->all());

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $data = Permission::find($id);
        $data->delete();
        return response()->json($data, 200);
    }
}
