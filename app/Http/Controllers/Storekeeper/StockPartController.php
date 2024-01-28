<?php

namespace App\Http\Controllers\Storekeeper;

use App\Models\StockPart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartInstrument;
use App\Models\PartType;
use App\Models\Station;
use App\Models\StockInstrument;

class StockPartController extends Controller
{
    public function index()
    {
        // $stockParts = PartInstrument::all();
        // $stockParts = $stockParts->with('stockInstrument')->get();
        // $stockParts = StockPart::checkStation()->filter()->latest('id')->get();
        // dd($stockParts);

        // $stockParts = StockPart::checkStation()->filter()->latest('id')->get();
        // return view('storekeeper.Stock.parts.index',['stockParts' => $stockParts,
        // 'manufactures' => Manufacture::all(),
        // 'partTypes' => PartType::all(),
        // 'stations' => Station::all(),
        // 'instruments' => Instrument::all(),
        // 'instrumentTypes' => InstrumentType::all(),]);

        // $stockParts = StockPart::checkStation()->filter()->latest('id')->get();
        // dd($stockParts);
        return view('storekeeper.Stock.parts.index',[
        'manufactures' => Manufacture::all(),
        'partTypes' => PartType::all(),
        'stations' => Station::all(),
        'instruments' => Instrument::all(),
        'instrumentTypes' => InstrumentType::all(),
        'stockParts' => Part::filter()->checkStation()->with('partType', 'manufacture','instrument')->latest('id')->get()]);
       
    }

    

    // public function stockPartInstrumentDetails( $id) {
    //     $stockParts = PartInstrument::where('sib_parts_id',$id);
    //     $stockParts = $stockParts->with('stockInstrument')->get();
    //     $stockInstruments = StockInstrument::checkStation()->latest('id')->get();
    //     return view('storekeeper.Stock.partInstruments.partInstruments', ['stockPart' => $stockParts,
    //     'stockInstruments' => $stockInstruments]);
    // }
}
