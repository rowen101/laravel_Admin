<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function index()
    {

        return view("core.role", []);
    }

    public function rolelist()
    {
        $data = Role::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = new Role();
        $request->validate([
            'role_code' => 'required',
            'description' => 'required',
        ]);
        $data->store($request->all());
        return response()->json($data, 200);
    }



    public function update(Request $request, $id)
    {
        $data =  Role::find($id);
        $request->validate([
            'role_code' => 'required',
            'description' => 'required',
        ]);


        $data->store($request->all());

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $data = Role::find($id);
        $data->delete();
        return response()->json($data, 200);
    }
}
