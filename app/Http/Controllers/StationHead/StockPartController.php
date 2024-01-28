<?php

namespace App\Http\Controllers\StationHead;

use App\Models\StockPart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartType;
use App\Models\Station;
use App\Models\StockInstrument;

class StockPartController extends Controller
{
    public function index()
    {
        // $stockParts = StockPart::checkStation()->filter()->latest('id')->get();
        return view('backend.stock.parts.index',[
            'manufactures' => Manufacture::all(),
            'partTypes' => PartType::all(),
            'stations' => Station::all(),
            'instruments' => Instrument::all(),
            'instrumentTypes' => InstrumentType::all(),
            'stockParts' => Part::filter()->checkStation()->with('partType', 'manufacture','instrument')->latest('id')->get()]);
    }

    public function stockPartInstrumentDetails( $id) {
        $stockPart = StockPart::checkStation()->findOrFail($id);
        $stockInstruments = StockInstrument::checkStation()->latest('id')->get();
        return view('storekeeper.Stock.partInstruments.partInstruments', ['stockPart' => $stockPart,
        'stockInstruments' => $stockInstruments]);
    }
}
