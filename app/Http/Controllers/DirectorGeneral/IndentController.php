<?php

namespace App\Http\Controllers\DirectorGeneral;

use App\Http\Controllers\Controller;
use App\Mail\IndentMail;
use App\Models\CentralIndent;
use App\Models\CentralIndentGroup;
use App\Models\Indent;
use App\Models\Manufacture;
use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

class IndentController extends Controller
{
    public function index()
    {
        $indents = Indent::status()
            ->filter()
            ->where('approved_by_sh_at', '!=', null)
            ->with(['station:id,name', 'manufacture:id,name'])
            ->latest('id')
            ->get();
            
        $manufactures = Manufacture::all();
        $stations = Station::all();

        return view('directorGeneral.indents.index', compact('indents', 'manufactures', 'stations'));
    }

    public function status($id)
    {
        $indent = Indent::status()
            ->findOrFail($id);
        $indent->update([
            'approved_by_dg_at' => isset($indent->approved_by_dg_at) ? null : now()
        ]);

        $role = Role::where(['slug' => 'intent-officer'])->first();
        $indentOfficer = User::where(['station_id' => $indent->station_id, 'role_id' => $role->id])->first();

        // $mailData = [
        //     'name' => $indentOfficer->name,
        //     'url' => env('APP_URL').'/intent-officer/indents',
        // ];
        // Mail::to($indentOfficer->email)->send(new IndentMail($mailData));
        notify()->success("Indent Status Changed", "Success");
        return back();
    }

    public function show($id)
    {
        $data['indent'] = Indent::status()
            ->findOrFail($id);
        return view('directorGeneral.indents.show', $data);
    }


    public function pdf($manufactureId)
    {   
        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining','central_indent_groups.unit_price', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();


        $pdf = PDF::loadView('DSE.CentralIndents.export', compact('details','manufacture'));
        return $pdf->download('Indent.pdf');
    }


    public function manufactureList(){
        $menufactureList = CentralIndent::with('manufacture')
                        ->get();

        return view('directorGeneral.centralIndents.index', compact('menufactureList'));
    }

    public function CIPartList($id){
        $indent = CentralIndent::findOrFail($id);
        $partLists = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity','central_indent_groups.unit_price', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                    ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                    ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                    ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                    ->where('central_indents.id', $id)
                    ->get();
        return view('directorGeneral.centralIndents.show', compact('indent','partLists'));
    }


    // public function changeStatus($id)
    // {   
    //     $indent = CentralIndent::findOrFail($id);
    //     $indent->update([
    //         'status' => $indent->status == true ? false : true
    //     ]);
    //     notify()->success("Status Changed", "Success");
    //     return back();
    // }

    
    public function approved($id)
    {       
        $indent = CentralIndent::findOrFail($id);
        $indent->update([
            'approved_by_dg_at' => isset($indent->approved_by_dg_at) ? null : now()
        ]);

        notify()->success("Indent Status Changed", "Success");
        return back();
    }


    public function createPDF($indent){
        $data['indent'] = Indent::with('station:id,name')->findOrFail($indent);


        $roleSlugsOne = ['station-incharge', 'station-head'];
        $roleSlugsTwo = ['central-engineer','main-engineer','director-general'];
        $roleIdsForStation = Role::whereIn('slug', $roleSlugsOne)->pluck('id')->toArray();
        $roleIdsWithoutStation = Role::whereIn('slug', $roleSlugsTwo)->pluck('id')->toArray();
        $globalUsers = User::whereIn('role_id', $roleIdsWithoutStation)->with('role','station')->get()->toArray();
        $data['users'] = array_merge($globalUsers);

        $pdf = PDF::loadView('DSE.indents.indentExport', $data);

        return $pdf->download('Indent.pdf');
    }
}
