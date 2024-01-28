<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InstrumentExport;
use App\Http\Controllers\Controller;
use App\Imports\InstrumentImport;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // dd($request->type);
        return view('backend.instruments.index', [
            'instruments' => Instrument::filter()->checkStation()
                ->latest('id')
                ->paginate(10),
            'instrumentsTypes' => InstrumentType::all(),
            'manufactures' => Manufacture::all(),
            'stations' => Station::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.instruments.form', [
            'instrumentsTypes' => InstrumentType::all(),
            'stations' => Station::latest('id')->get(),
            'manufactures' => Manufacture::latest('id')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'instrument_id' => 'unique:instruments',
            'name' => 'nullable|string',
            'station' => 'nullable',
            'type' => 'nullable',
            'manufacture' => 'nullable',
            'model' => 'nullable',
            'date' => 'nullable|date',
            'attached_file' => 'nullable|mimes:pdf',
        ]);

        $stations = Station::all();

       foreach ($stations as $station) {
        $station_code = $station->name;
        if(strlen($station_code) > 2 ) {
            $station_code = substr($station_code, 0, 2);
            $station_code = strtolower($station_code);
        }
        $referal_code = random_int(1000, 999999);
        $instrument_id = $station_code.'-'. $referal_code;

        $attached_file=$request->file('attached_file');

        if (isset($attached_file)){
            $attached_file_name= time().'_'.$attached_file->getClientOriginalName();
        }


        Instrument::create([
            'instrument_id' => $instrument_id,
            'name' => $request->get('name'),
            'station_id' => $station->id,
            'description' => $request->get('description'),
            'instrument_type_id' => $request->get('type'),
            'model' => $request->get('model'),
            'serial_no' => $request->get('serial_no'),
            'quantity' => 1,
            // 'quantity' =>(!Auth::user()->isAdmin()) ? ($station->id == Auth::user()->station->id ? 1: 0) : 0,
            'manufacture_id' => $request->get('manufacture'),
           'installation_date' => $request->get('installation_date'),
           'attachment_path'=>$request->hasFile('attached_file')?$request->file('attached_file')->storeAs('AttacheFile',$attached_file_name):null
        ]);
       }

        notify()->success('Instrument Added.', 'Added');
        return redirect()->route('admin.instruments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Instrument $instrument
     * @return \Illuminate\Http\Response
     */
    public function show(Instrument $instrument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Instrument $instrument
     * @return \Illuminate\Http\Response
     */
    public function edit(Instrument $instrument)
    {
        return view('backend.instruments.form', [
            'instrumentsTypes' => InstrumentType::all(),
//            'stations' => Station::latest('id')->get(),
            'manufactures' => Manufacture::latest('id')->get(),
            'instrument' => $instrument
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Instrument $instrument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instrument $instrument)
    {
        $this->validate($request, [
            'instrument_id' => 'required',
            'name' => 'required',
//            'station' => 'required',
            'type' => 'required',
            'manufacture' => 'required',
        ]);

        $instrument->update([
            'instrument_id' => $request->get('instrument_id'),
            'name' => $request->get('name'),
//            'station_id' => $request->get('station'),
            'description' => $request->get('description'),
            'instrument_type_id' => $request->get('type'),
            'model' => $request->get('model'),
            'serial_no' => $request->get('serial_no'),
            'manufacture_id' => $request->get('manufacture'),
//            'installation_date' => $request->get('installation_date'),
        ]);

        notify()->success('Instrument Updated.', 'Updated');
        return redirect()->route('admin.instruments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Instrument $instrument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instrument $instrument)
    {
        $instrument->delete();
        notify()->success("Instrument Deleted", "Deleted");
        return back();
    }

    // Excel export method
    public function export()
    {
        return Excel::download(new InstrumentExport, 'instruments-' . Carbon::parse()->toDateString() . '.xlsx');
    }

    // Method for import file
    public function storeImport(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);
        // dd($request->file('file'));

        Excel::import(new InstrumentImport(), $request->file('file'));
        notify()->success('Imported Successfully', 'Added');
        return redirect()->route('admin.instruments.index');
    }
}
