<?php

namespace App\Http\Controllers\DSE;

use App\Http\Controllers\Controller;
use App\Models\CentralIndent;
use App\Models\CentralIndentGroup;
use App\Models\Indent;
use App\Models\Manufacture;
use App\Models\PartIndent;
use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class IndentController extends Controller
{
    public function index()
    {   
        $indents = Indent::status()
            ->filter()
            ->where('approved_by_sh_at', '!=', null)
            ->where('approved_for_cen_ind','!=',null)
            ->with(['station:id,name', 'manufacture:id,name'])
            ->latest('id')
            ->get();
            
        $manufactures = Manufacture::all();
        $stations = Station::all();

        return view('DSE.indents.index', compact('indents', 'manufactures','stations'));
    }

    
    public function show($id)
    {
        $data['indent'] = Indent::status()->findOrFail($id);
        return view('DSE.indents.show', $data);
    }


    public function generateCentralIndent(Request $request)
    {   
        $manufactureId = $request->indentGenerate;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $partIndents = PartIndent::join('indents', 'part_indents.indent_id', '=', 'indents.id')
                ->join('parts', 'part_indents.part_id','=', 'parts.id')
                ->whereHas('part', function ($query) use ($manufactureId) {
                    $query->where('manufacture_id', $manufactureId);
                })
                ->whereBetween('indents.date', [$startDate, $endDate])
                ->select('part_indents.*','indents.*','parts.parts_no')
                ->get();

        $findingDetails = $partIndents->groupBy('parts_no')->map(function ($group) {
            $totalQuantity = $group->sum('quantity');
            $partInfo = $group->first()->part;
           
            $stationIds = $group->pluck('station_id')->unique()->toArray();
            $stationNames = Station::whereIn('id', $stationIds)->pluck('name')->toArray();

            $quantity = $group->pluck('quantity')->toArray();
            // dd($stationNames,$totalQuantity);

            $stationQuantityArray = array_combine($stationNames, $quantity);

    
        
            return [
                'id' => $group->first()->part_id,
                'name' => $partInfo->name,
                'no' => $partInfo->parts_no,
                'total_quantity' => $totalQuantity,
                'station_quantity' => $stationQuantityArray,
                'st_id' => $stationIds,
                'st_name' => $stationNames,
                'st_quantity' => $quantity,
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
                'station_quantity'  => json_encode($detail['station_quantity']),   
                'st_id'  => json_encode($detail['st_id']),   
                'st_name'  => json_encode($detail['st_name']),   
                'st_quantity'  => json_encode($detail['st_quantity']),    
                'date'              => now()
            ]);
        }

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining','central_indent_groups.unit_price', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();
        
        return view('DSE.centralIndents.manufacture_products', compact('details','manufacture'));
    }


    public function requisitionUpdate(Request $request, $part_id, $centralIndentID)
    {   
        $manufactureId = CentralIndent::findOrFail($centralIndentID)->manufacture_id;
        
        $requisition = $request->requisition;
        $unit_price = $request->unit_price;
        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $UpdateRequisition = CentralIndentGroup::where('central_indent_id',$centralIndentID)
                    ->where('part_id',$part_id)
                    ->update([
                        'remaining' => $requisition,
                        'unit_price' => $unit_price
                    ]);

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining','central_indent_groups.unit_price','parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();
        
        notify()->success("Requisition Updated", "Success");
        return view('DSE.centralIndents.manufacture_products', compact('details','manufacture'));
 
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

    public function report1($manufactureId)
    {   
        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining','central_indent_groups.unit_price', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();

        $pdf = PDF::loadView('DSE.CentralIndents.report1', compact('details','manufacture'));
        return $pdf->download('Report1.pdf');
    }


    public function manufactureList()
    {
        $menufactureList = CentralIndent::with('manufacture','user')->get();
        return view('DSE.centralIndents.index', compact('menufactureList'));
    }
    

    public function CIPartList($id)
    {
        $indent = CentralIndent::findOrFail($id);
        // $partLists = CentralIndentGroup::where('central_indent_id',$id)->get();
        $partLists = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity','central_indent_groups.unit_price', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.id', $id)
                ->get();
        
        return view('DSE.centralIndents.show', compact('indent','partLists'));
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


    public function stationwiseQuantity($manufactureId){
        $manufacture = Manufacture::select('id','name')->find($manufactureId);        

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.station_quantity','central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining','central_indent_groups.unit_price', 'parts.name','parts.parts_no','part_types.name as type')
                    ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                    ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                    ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                    ->where('central_indents.manufacture_id', $manufactureId)
                    ->get();


        // dd($details);

        $pdf = PDF::loadView('DSE.CentralIndents.stationWiseExport', compact('details','manufacture'));
        return $pdf->stream('Indent.pdf');
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
