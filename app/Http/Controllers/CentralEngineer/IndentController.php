<?php

namespace App\Http\Controllers\CentralEngineer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CentralEngineer\Indents\ManufacturewiseProducts;
use App\Mail\IndentMail;
use App\Models\CentralIndent;
use App\Models\CentralIndentGroup;
use App\Models\Indent;
use App\Models\Manufacture;
use App\Models\PartIndent;
use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\RequestStack;
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
        return view('centralEngineer.indents.index', compact('indents', 'manufactures', 'stations'));
    }

    public function status($id)
    {
        $indent = Indent::status()->findOrFail($id);
        $indent->update([
            'approved_by_ce_at' => isset($indent->approved_by_ce_at) ? null : now()
        ]);

        $role = Role::where(['slug' => 'main-engineer'])->first();
        $mainEngineer = User::where(['role_id' => $role->id])->first();
        // $mailData = [
        //     'name' => $mainEngineer->name,
        //     'url' => env('APP_URL') . '/main-engineer/indents',
        // ];
        // Mail::to($mainEngineer->email)->send(new IndentMail($mailData));
        notify()->success("Indent Status Changed", "Success");
        return back();
    }

    
    public function show($id)
    {
        $data['indent'] = Indent::status()->findOrFail($id);
        return view('centralEngineer.indents.show', $data);
    }


    public function generateCentralIndent(Request $request)
    {
        $manufactureId = $request->indentGenerate;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $partIndents = PartIndent::join('indents', 'part_indents.indent_id', '=', 'indents.id')
                ->whereHas('part', function ($query) use ($manufactureId) {
                    $query->where('manufacture_id', $manufactureId);
                })
                ->whereBetween('indents.date', [$startDate, $endDate])
                ->get();
        
        // $findingDetails = $partIndents->groupBy('part_id')->map(function ($group) {
        //     $totalQuantity = $group->sum('quantity');
        //     $partInfo = $group->first()->part;
        $findingDetails = $partIndents->groupBy('parts_no')->map(function ($group) {
            $totalQuantity = $group->sum('quantity');
            $partInfo = $group->first()->part;
            // $partTypeName = $partInfo->partType->name;
        
            return [
                'id' => $group->first()->part_id,
                'name' => $partInfo->name,
                'no' => $partInfo->parts_no,
                'total_quantity' => $totalQuantity,
            ];
        })->values();

        $findPreviousRecord = CentralIndent::select('id')->where('manufacture_id',$manufactureId)->first();

        if($findPreviousRecord){
            $PreCentralIndentID = $findPreviousRecord->id;

            CentralIndent::where('manufacture_id',$manufactureId)->delete();
            CentralIndentGroup::where('central_indent_id',$PreCentralIndentID)->delete();
        }

        $centralIndent = CentralIndent::create([
                        'manufacture_id' => $manufactureId,
                        'date'           => now()
                    ]);

        $centralIndentID = $centralIndent->id;

        foreach ($findingDetails as $detail) {
            CentralIndentGroup::create([
                'central_indent_id' => $centralIndentID ,
                'part_id'           => $detail['id'],
                'manufacture_id'    => $manufactureId,
                'quantity'          => $detail['total_quantity'],
                'date'              => now()
            ]);
        }

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();
        
        return view('centralEngineer.indents.manufacture_products', compact('details','manufacture'));
    }


    public function requisitionUpdate(Request $request, $part_id, $centralIndentID)
    {   
        $manufactureId = CentralIndent::findOrFail($centralIndentID)->manufacture_id;
        
        $requisition = $request->requisition;
        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $UpdateRequisition = CentralIndentGroup::where('central_indent_id',$centralIndentID)
                    ->where('part_id',$part_id)
                    ->update([
                        'remaining' => $requisition
                    ]);

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();
        
        notify()->success("Requisition Updated", "Success");
        return view('centralEngineer.indents.manufacture_products', compact('details','manufacture'));
 
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



    public function finalApproved($id){
        $user_id = Auth::user()->id;
        $indent = CentralIndent::findOrFail($id);
        $finalApproval = $indent->final_approval;
        
        if($finalApproval == 0){
            $indent->update([
                'final_approval' => true,
                'approved_by_ce_at' =>  now(),
                'approved_by_dg_at' =>  now(),
                'final_approval_by' => $user_id,
            ]);
        }
        else {
            $indent->update([
                'final_approval' => false,
                'approved_by_ce_at' => null,
                'approved_by_dg_at' => null,
                'final_approval_by' => null,

            ]);
        }

        notify()->success("Final Approved", "Success");
        return back();
    }



    public function manufactureList(){
        $menufactureList = CentralIndent::with('manufacture','user')
                        ->get();

        return view('centralEngineer.centralIndents.index', compact('menufactureList'));
    }

    public function CIPartList($id){
        $indent = CentralIndent::findOrFail($id);
        $partLists = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity','central_indent_groups.unit_price', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                    ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                    ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                    ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                    ->where('central_indents.id', $id)
                    ->get();
                    
        return view('centralEngineer.centralIndents.show', compact('indent','partLists'));
    }


    public function changeStatus($id)
    {   
        $indent = CentralIndent::findOrFail($id);
        $indent->update([
            'status' => $indent->status == true ? false : true
        ]);
        notify()->success("Status Changed", "Success");
        return back();
    }

    
    public function approved($id)
    {   
        $indent = CentralIndent::findOrFail($id);
        $indent->update([
            'approved_by_ce_at' => isset($indent->approved_by_ce_at) ? null : now()
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
