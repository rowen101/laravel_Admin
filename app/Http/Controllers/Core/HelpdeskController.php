<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\CoreApp;
use App\Models\Core\HelpPage;
use App\Models\Core\HelpSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelpdeskController extends Controller
{

    public function index()
    {

        return view('core.helpdisk');
    }

    public function sectionlist($id)
    {
        $data = HelpSection::find($id);
        return response()->json($data);
    }
    public function systemName()
    {
        $data = CoreApp::select('id', 'app_name')->with('help_sections')->get();
        return response()->json($data, 200);
    }

    public function storeSection(Request $request)
    {
        $data = new HelpSection();

        $request->validate([
            'systemID' => 'required',
            'section_name' => 'required',

        ]);

        $data->store($request->all());
        return response()->json($data, 200);
    }
    public function deleteSection($id)
    {
        $data =
            DB::table("help_pages")->where("section_id", $id)->delete();
        $data = DB::table("help_sections")->where("id", $id)->delete();

        return response()->json($data, 200);
    }

    public function sectionPageList($id)
    {

        $data = HelpPage::where('section_id', $id)->get(['id', 'uuid', 'section_id', 'page_name', 'page_body', 'is_publish', 'created_at', 'updated_at']);
        return response()->json($data, 200);
    }
    public function storeSectionPage(Request $request)
    {
        $data = new HelpPage();

        $request->validate([
            'section_id' => 'required',
            'page_name' => 'required',
            'page_body' => 'required',
            'is_publish' => 'required'

        ]);

        $data->store($request->all());
        return response()->json($data, 200);
    }
    public function getPagebyID($id)
    {
        $data = HelpPage::find($id);
        return response()->json($data, 200);
    }
    public function updateSectionPage(Request $request, $id)
    {
        $data =  HelpPage::find($id);

        $request->validate([
            'section_id' => 'required',
            'page_name' => 'required',
            'page_body' => 'required',
            'is_publish' => 'required'

        ]);

        $data->store($request->all());
        return response()->json($data, 200);
    }
    public function deleteSectionPage($id)
    {
        $data = HelpPage::find($id);
        $data->delete();
        return response()->json($data, 200);
    }
}
