<?php

namespace App\Http\Controllers;
use App\Models\StockInstrument;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\PartType;
use App\Models\Station;
use Illuminate\Http\Request;

class ShareInstrumentController extends Controller
{
    public function index()
    {
        $shareInstruments = StockInstrument::filter()->latest('id')->paginate(100);
        return view('Share.instruments.index',['shareInstrumentsss'=>$shareInstruments,
        'instrumentTypes'=> InstrumentType::all(),
        'manufactures'=>Manufacture::all(),
        'stations'=>Station::all(),
        'shareInstruments' => Instrument::filter()->latest('id')->paginate(10)]);
    }
}
