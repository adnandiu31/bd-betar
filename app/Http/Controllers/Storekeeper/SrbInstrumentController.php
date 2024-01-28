<?php

namespace App\Http\Controllers\Storekeeper;

use App\Models\Srb;
use App\Models\SrbPart;
use App\Models\SrbInstrument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SrbInstrumentController extends Controller
{
    public function instrumentStore(Request $request,Srb $srb,SrbInstrument $instrument){
        $request->validate([
            'unit'=>'required|integer|min:1|between:1,'.$instrument->quantity
        ]);
        $instrument->update([
            'unit'=>$request->unit,
            'remaining'=>$instrument->quantity-$request->unit
        ]);
        notify()->success("Instrument unit updated", "Updated");
        return back();
    }

    public function partStore(Request $request,Srb $srb,SrbPart $part){
        $request->validate([
            'unit'=>'required|integer|min:1|between:1,'.$part->quantity
        ]);
        $part->update([
            'unit'=>$request->unit,
            'remaining'=>$part->quantity-$request->unit
        ]);
        notify()->success("Part unit updated", "Updated");
        return back();
    }
}
