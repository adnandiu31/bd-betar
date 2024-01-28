<?php

namespace App\Http\Controllers\StationIncharge;

use App\Models\Sib;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PartInstrument;
use App\Models\SibPart;
use App\Models\StockInstrument;
use App\Models\StockPart;

class SibController extends Controller
{
    public function index()
    {
        $sibs = Sib::status()
            ->checkStation()
            ->latest()
            ->get();
        return view('stationIncharge.sib.index', compact('sibs'));
    }
    public function show($id)
    {
        $data['sib'] = Sib::checkStation()->findOrFail($id);
        return view('stationIncharge.sib.show', $data);
    }

    public function changeStatus($sib)
    {
        $sib = Sib::status()->checkStation()->findOrFail($sib);
        $sib->update([
            'approved_by_si_at' => isset($sib->approved_by_si_at) ? null: now()
        ]);
        notify()->success("SIB Status Changed", "Success");
        return back();
    }

    public function stockPartInstrumentDetails( $id) {
        
        $stockParts = PartInstrument::where('sib_parts_id',$id);
        $stockParts = $stockParts->with('stockInstrument')->get();
        // dd($stockParts);
        $stockPart = StockPart::checkStation()->findOrFail($id);
        $sibPart = SibPart::findOrFail($id);
        $stockInstruments = StockInstrument::checkStation()->latest('id')->get();
        return view('Share.parts.partInstruments', ['stockPart' => $stockPart,'parts'=>$stockParts,'stockInstruments'=>$stockInstruments,'sibPart'=>$sibPart]);
    }
}
