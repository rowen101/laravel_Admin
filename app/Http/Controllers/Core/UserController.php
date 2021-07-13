<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Role;
use App\Models\Core\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    function index()
    {

        return view("core.user", []);
    }
    public function rolelist()
    {
        $data = Role::where('is_active', '1')->get(['id', 'role_code']);
        return response()->json($data);
    }
    public function userlist()
    {

        $data = User::select('id', 'name', 'user_type', 'first_name', 'last_name', 'is_active', 'role_id')->get();
        $data = User::all();
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $user = new User();

        $data['email'] = $request->input('app_id');
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['is_active'] = $request->input('is_active');

        $user->store($data);

        return response()->json($user);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {

        $user =  User::find($id);

        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['name'] = $request->input('name');
        $data['user_type'] = $request->input('user_type');
        $data['role_id'] = $request->input('role_id');
        $data['is_active'] = $request->input('is_active');
        $user->store($data);

        // $user->store(["first_name" => $request->first_name]);


        return response()->json($user);


        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
    }

    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return response()->json($data, 200);
    }
}
