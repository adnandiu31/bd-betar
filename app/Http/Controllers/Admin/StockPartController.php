<?php

namespace App\Http\Controllers\Admin;

use App\Models\Part;
use App\Models\Station;
use App\Models\StockInstrument;
use App\Models\StockPart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\PartType;
use Illuminate\Support\Facades\Auth;

class StockPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user()->id);
        // $stockParts = StockPart::filter()->checkStation()->latest('id')->get();
        return view('backend.stock.parts.index',[
        'manufactures' => Manufacture::all(),
        'partTypes' => PartType::all(),
        'stations' => Station::all(),
        'instruments' => Instrument::all(),
        'instrumentTypes' => InstrumentType::all(),
        'stockParts' => Part::filter()->checkStation()->with('partType', 'manufacture','instrument')->latest('id')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data['stations'] = Station::all();
        $data['parts'] = Part::filter()->checkStation()
        ->latest('id')
        ->get();
        return view('backend.stock.parts.form',$data);
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
            'part' => 'required',
            'quantity' => 'required',
            'station'=>'nullable'
        ]);
        $stockPart = StockPart::where('station_id',$request->station)
            ->where('part_id',$request->part)->first();
        if (isset($stockPart))  {
            $stockPart->update([
                'quantity' => (int)$stockPart->quantity + (int)$request->quantity
            ]);
        } else {
            StockPart::create([
                'station_id' => Auth::user()->station->id,
                'part_id' => $request->part,
                'quantity' => $request->quantity
            ]);
        }

        notify()->success('Part Added To Stock.', 'Added');
        return redirect()->route('admin.stock.parts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockPart  $stockPart
     * @return \Illuminate\Http\Response
     */
    public function show(StockPart $stockPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockPart  $stockPart
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['stations'] = Station::all();
        $data['parts'] = Part::all();
        $data['stockPart'] = StockPart::checkStation()
            ->findOrFail($id);

        return view('backend.stock.parts.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockPart  $stockPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'part' => 'required',
            'quantity' => 'required',
            'station'=>'required'
        ]);
        $stockPart = StockPart::checkStation()
            ->findOrFail($id);

        $stockPart->update([
            'station_id' => $request->station,
            'part_id' => $request->part,
            'quantity' => $request->quantity
        ]);

        notify()->success('Part Updated.', 'Added');
        return redirect()->route('admin.stock.parts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockPart  $stockPart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stockPart = StockPart::checkStation()
            ->findOrFail($id);
        $stockPart->delete();
        notify()->success("Part Deleted", "Deleted");
        return back();
    }
}
