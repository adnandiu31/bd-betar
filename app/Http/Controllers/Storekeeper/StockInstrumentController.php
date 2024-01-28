<?php

namespace App\Http\Controllers\Storekeeper;

use App\Models\StockInstrument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Station;

class StockInstrumentController extends Controller
{
    public function index()
    {
        // $stockInstruments = StockInstrument::checkStation()->filter()->latest('id')->get();
        return view('storekeeper.Stock.instruments.index',[
        'manufactures' => Manufacture::all(),
        'instruments' => Instrument::all(),
        'stations' => Station::all(),
        'instrumentTypes' => InstrumentType::all(),
        'stockInstruments' => Instrument::filter()->checkStation()->with('instrumentType', 'manufacture')->latest('id')->get()]);
    }
}
