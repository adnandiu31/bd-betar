<?php

namespace App\Http\Controllers\ACE;

use App\Http\Controllers\Controller;
use App\Http\Resources\CentralEngineer\Indents\ManufacturewiseProducts;
use App\Mail\IndentMail;
use App\Models\CentralIndent;
use App\Models\CentralIndentGroup;
use App\Models\Indent;
use App\Models\Manufacture;
use App\Models\PartIndent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\RequestStack;
use PDF;

class IndentController extends Controller
{

    public function manufactureList(){
        $menufactureList = CentralIndent::with('manufacture','user')
                        ->get();

        return view('SEM.centralIndents.index', compact('menufactureList'));
    }

    public function CIPartList($id){
        $indent = CentralIndent::findOrFail($id);
        // $partLists = CentralIndentGroup::where('central_indent_id',$id)->get();
        $partLists = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.id', $id)
                ->get();
        
        return view('SEM.centralIndents.show', compact('indent','partLists'));
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
            'approved_by_sem_at' => isset($indent->approved_by_sem_at) ? null : now()
        ]);

        notify()->success("Indent Approved", "Success");
        return back();
    }

    public function pdf($manufactureId)
    {   
        $manufacture = Manufacture::select('id','name')->find($manufactureId);

        $details = DB::table('central_indent_groups')->select('central_indent_groups.id', 'central_indent_groups.part_id', 'central_indent_groups.central_indent_id', 'central_indent_groups.quantity', 'central_indent_groups.remaining', 'parts.name','parts.parts_no','part_types.name as type')
                ->join('parts', 'central_indent_groups.part_id', '=', 'parts.id')
                ->join('part_types', 'part_types.id', '=', 'parts.part_type_id')
                ->join('central_indents','central_indents.id', '=', 'central_indent_groups.central_indent_id')
                ->where('central_indents.manufacture_id', $manufactureId)
                ->get();


        $pdf = PDF::loadView('SEM.indents.export', compact('details','manufacture'));
        return $pdf->download('Indent.pdf');
    }

}
