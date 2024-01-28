<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstrumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstrumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.instrument-types.index',[
            'instrumentTypes' => InstrumentType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.instrument-types.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|unique:instrument_types'
        ]);
        InstrumentType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        notify()->success('Instrument Type Added.', 'Added');
        return redirect()->route('admin.instrument-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstrumentType  $instrumentType
     * @return \Illuminate\Http\Response
     */
    public function show(InstrumentType $instrumentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstrumentType  $instrumentType
     * @return \Illuminate\View\View
     */
    public function edit(InstrumentType $instrumentType)
    {
        return view('backend.instrument-types.form',compact('instrumentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstrumentType  $instrumentType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, InstrumentType $instrumentType)
    {
        $this->validate($request,[
            'name' => 'required|string|unique:instrument_types,name,'. $instrumentType->id
        ]);
        $instrumentType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        notify()->success('Instrument Type Updated.', 'Updated');
        return redirect()->route('admin.instrument-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstrumentType  $instrumentType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(InstrumentType $instrumentType)
    {
        $instrumentType->delete();
        notify()->success("Instrument Type Deleted", "Deleted");
        return back();
    }
}
