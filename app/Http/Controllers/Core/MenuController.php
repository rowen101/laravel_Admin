<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\CoreApp;
use App\Models\Core\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    function index()
    {

        return view("core.menu");
    }

    function menulist()
    {
        $data = CoreApp::select('id', 'app_name')->with('menus')->get();
        return response()->json($data, 200);
    }



    function store(Request $request)
    {
        $data = new Menu;

        $request->validate([
            'app_id' => 'required',
            'menu_code' => 'required',
            'menu_title' => 'required',
            'description' => 'required',

        ]);
        $data->store($request->all());
        return response()->json($data, 200);
    }

    function update(Request $request, $id)
    {
        $data =  Menu::find($id);
        $request->validate([
            'app_id' => 'required',
            'menu_code' => 'required',
            'menu_title' => 'required',
            'description' => 'required',

        ]);
        $data->store($request->all());

        return response()->json($data, 200);
    }
    function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return response()->json($menu, 200);
    }
}
