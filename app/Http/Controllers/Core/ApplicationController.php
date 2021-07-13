<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\CoreApp;

class ApplicationController extends Controller
{
    function index()
    {
        return view("core.application");
    }
    public function applist()
    {
        $coreapps = CoreApp::all();
        return response()->json($coreapps, 200);
    }

    public function store(Request $request)
    {
        $coreapps = new CoreApp;
        $request->validate([
            'app_code' => 'required',
            'app_name' => 'required',
            'description' => 'required',
        ]);
        $coreapps->store($request->all());
        return response()->json($coreapps, 200);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'app_code' => 'required',
            'app_name' => 'required',
            'description' => 'required',
        ]);

        $coreapps = CoreApp::find($id);
        $coreapps->store($request->all());

        return response()->json($coreapps, 200);
    }

    public function destroy($id)
    {
        $coreapps = CoreApp::find($id);
        $coreapps->delete();
        return response()->json($coreapps, 200);
    }
}
