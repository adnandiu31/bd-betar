<?php

namespace App\Http\Controllers;

use App\Models\StockPart;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartType;
use App\Models\Station;
use App\Models\StockInstrument;
use Illuminate\Http\Request;

class SharePartController extends Controller
{
    public function index()
    {
//        if (request()->query('search') !== null) {
//            dd(request()->query('search'));
//        }
        $searchTerm = request()->query('search');
        $shareparts = Stockpart::filter()->latest('id')->paginate(10);
        return view('Share.parts.index', [
            'sharepartss' => $shareparts,
            'partTypes' => PartType::all(),
            'instruments' => Instrument::all(),
            'manufactures' => Manufacture::all(),
            'stations' => Station::all(),
            'shareparts' => Part::filter()->latest('id')->paginate(10)->appends(['search' => $searchTerm])]);
    }

    public function stockPartInstrumentDetails($id)
    {
        $stockPart = StockPart::findOrFail($id);
        $stockInstruments = StockInstrument::latest('id')->get();
        return view('Share.parts.partInstruments', ['stockPart' => $stockPart,
            'stockInstruments' => $stockInstruments]);
    }
}
