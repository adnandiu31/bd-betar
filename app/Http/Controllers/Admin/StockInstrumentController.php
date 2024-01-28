<?php

namespace App\Http\Controllers\Admin;

use App\Models\Station;
use App\Models\Instrument;
use App\Models\StockInstrument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use Illuminate\Support\Facades\Auth;

class StockInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $stockInstruments = StockInstrument::filter()->checkStation()->latest('id')->get();
        return view('backend.stock.instruments.index',[
                    'manufactures' => Manufacture::all(),
                    'instruments' => Instrument::all(),
                    'stations' => Station::all(),
                    'instrumentTypes' => InstrumentType::all(),
                    'stockInstruments' => Instrument::filter()->checkStation()->with('instrumentType', 'manufacture')->latest('id')->get()
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data['stations'] = Station::all();
        $data['instruments'] = Instrument::filter()->checkStation()
        ->latest('id')
        ->get();
        return view('backend.stock.instruments.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'instrument' => 'required',
            'quantity' => 'required',
            'station'=>'nullable'
        ]);
        $stockInstrument = StockInstrument::where('station_id',$request->station)
            ->where('instrument_id',$request->instrument)->first();
        if (isset($stockInstrument))  {
            $stockInstrument->update([
                'quantity' => (int)$stockInstrument->quantity + (int)$request->quantity,
                // 'station_id'=>$request->station,
            ]);
        } else {
            StockInstrument::create([
                'station_id' =>Auth::user()->station->id,
                'instrument_id' => $request->instrument,
                'quantity' => $request->quantity
            ]);
        }

        notify()->success('Instrument Added To Stock.', 'Added');
        return redirect()->route('admin.stock.instruments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockInstrument  $stockInstrument
     * @return \Illuminate\Http\Response
     */
    public function show(StockInstrument $stockInstrument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockInstrument  $stockInstrument
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['stations'] = Station::all();
        $data['instruments'] = Instrument::all();
        $data['stockInstrument'] = StockInstrument::checkStation()
            ->findOrFail($id);

        return view('backend.stock.instruments.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockInstrument  $stockInstrument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'instrument' => 'required',
            'quantity' => 'required',
            'station'=>'required'
        ]);
        $stockInstrument = StockInstrument::checkStation()
            ->findOrFail($id);

        $stockInstrument->update([
            'station_id' => $request->station,
            'instrument_id' => $request->instrument,
            'quantity' => $request->quantity,

        ]);

        notify()->success('Instrument Updated.', 'Added');
        return redirect()->route('admin.stock.instruments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockInstrument  $stockInstrument
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stockInstrument = StockInstrument::checkStation()
            ->findOrFail($id);
        $stockInstrument->delete();
        notify()->success("Instrument Deleted", "Deleted");
        return back();
    }
}
