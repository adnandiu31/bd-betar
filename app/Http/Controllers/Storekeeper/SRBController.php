<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\Controller;
use App\Models\Indent;
use App\Models\Instrument;
use App\Models\Part;
use App\Models\Role;
use App\Models\Srb;
use App\Models\SrbInstrument;
use App\Models\SrbPart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class SRBController extends Controller
{
    public function index()
    {
        $srbs = Srb::checkStation()->get();
        $indents = Indent::allApproved()->get();
        return view('storekeeper.srb.index', compact('srbs', 'indents'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'indent' => 'required'
        ]);
        $indent = Indent::findOrFail($request->get('indent'));
        $srb = Srb::updateOrCreate([
            'station_id' => Auth::user()->station->id,
            'indent_id' => $indent->id,
            'attempts' => 1,
            'status' => false
        ]);
        if ($indent->product_type == 'instrument') {
            foreach ($indent->hasRemaining() as $instrumentIndent) {
                SrbInstrument::create([
                    'srb_id' => $srb->id,
                    'instrument_id' => $instrumentIndent->instrument->id,
                    'quantity' => $instrumentIndent->remaining,
                    'remaining' => $instrumentIndent->remaining,
                ]);
            }
        } else {
            foreach ($indent->hasRemaining() as $partIndent) {
                SrbPart::create([
                    'srb_id' => $srb->id,
                    'part_id' => $partIndent->part->id,
                    'quantity' => $partIndent->remaining,
                    'remaining' => $partIndent->remaining,
                ]);
            }
        }
        return redirect()->route('storekeeper.srb.edit', $srb->id);
    }

    public function edit($id)
    {
        $srb = Srb::findOrFail($id);
        return view('storekeeper.srb.form', compact('srb'));
    }

    public function storeProduct($id)
    {
        $srb = Srb::findOrFail($id);
        return view('storekeeper.srb.form', compact('srb'));
    }

    public function changeStatus($srb)
    {
        $srb = Srb::checkStation()->findOrFail($srb);
        $srb->update([
            'status' => $srb->status == true ? false : true
        ]);
        notify()->success("Srb Status Changed", "Success");
        return back();
    }

    public function show($id)
    {
        $data['srb'] = Srb::checkStation()->findOrFail($id);
        return view('storekeeper.srb.show', $data);
    }

    public function adjust($srb)
    {
        $srb = Srb::checkStation()->where('id', $srb)->where('adjust', false)->first();
        if ($srb->indent->product_type == 'instrument') {
            foreach ($srb->instruments as $srbinstrument) {
                // $stock=StockInstrument::checkStation()->whereHas('instrument',function($query) use($srbinstrument){
                //     return $query->where('id',$srbinstrument->instrument->id);
                // })->first();
                $stock = Instrument::checkStation()->where('id', $srbinstrument->instrument->id)->first();
                //    dd($stock->quantity,$srbinstrument->unit);
                $stock->update([
                    'quantity' => $stock->quantity + $srbinstrument->unit
                ]);

                $indent = $srb->indent->instruments()->where('instrument_id', $srbinstrument->instrument->id)->first();
                $indent->update([
                    'remaining' => $indent->remaining - $srbinstrument->unit
                ]);
            }
        } else {
            foreach ($srb->parts as $srbpart) {
                // $stock=StockPart::checkStation()->whereHas('part',function($query) use($srbpart){
                //     return $query->where('id',$srbpart->part->id);
                // })->first();

                $stock = Part::checkStation()->where('id', $srbpart->part->id)->first();
                //    dd($stock->quantity,$srbpart->unit);
                $stock->update([
                    'quantity' => $stock->quantity + $srbpart->unit
                ]);
                $indent = $srb->indent->PARTS()->where('part_id', $srbpart->part->id)->first();
                $indent->update([
                    'remaining' => $indent->remaining - $srbpart->unit
                ]);
            }
        }
        notify()->success("Stock Updated", "Updated");
        $srb->update([
            'adjust' => true
        ]);
        return back();
    }

    public function destroy($id)
    {
        Srb::checkStation()->findOrFail($id)->delete();
        notify()->success("Srb Request Deleted", "Deleted");
        return back();
    }

    public function createPDF($srb)
    {
        $data['srb'] = Srb::checkStation()->with('indent')->findOrFail($srb);

        $roleSlugsOne = ['station-incharge', 'station-head'];
        $roleSlugsTwo = ['central-engineer','main-engineer','director-general'];
        $roleIdsForStation = Role::whereIn('slug', $roleSlugsOne)->pluck('id')->toArray();
        $roleIdsWithoutStation = Role::whereIn('slug', $roleSlugsTwo)->pluck('id')->toArray();
        $stationUsers = User::checkStation()->whereIn('role_id', $roleIdsForStation)->with('role','station')->get()->toArray();
        $globalUsers = User::whereIn('role_id', $roleIdsWithoutStation)->with('role','station')->get()->toArray();
        $data['users'] = array_merge($stationUsers, $globalUsers);


        $pdf = PDF::loadView('storekeeper.srb.export', $data);

        $name = "srb".rand(0,99999).".pdf";
        // download PDF file with download method
        return $pdf->download($name);
    }

}
