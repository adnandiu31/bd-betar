<?php

namespace App\Http\Controllers\StationHead;

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
            ->where('approved_by_si_at','!=', null)
            ->latest()
            ->get();
        return view('stationHead.sib.index',compact('sibs'));
    }

    public function show($id)
    {
        $data['sib'] = Sib::checkStation()->findOrFail($id);
        return view('stationHead.sib.show', $data);
    }

    public function changeStatus($srb)
    {
        $sib = Sib::status()->checkStation()->findOrFail($srb);
        $sib->update([
            'approved_by_sh_at' => isset($sib->approved_by_sh_at) ? null: now()
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
