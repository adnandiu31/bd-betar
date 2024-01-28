<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.stations.index', [
            'stations' => Station::latest('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.stations.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:stations',
            'address' => 'required',
        ]);
        Station::create([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
        ]);
        notify()->success('Station Successfully Added.', 'Added');
        return redirect()->route('admin.stations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function show(Station $station)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\View\View
     */
    public function edit(Station $station)
    {
        return view('backend.stations.form', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Station $station
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Station $station)
    {
        $this->validate($request, [
            'name' => 'required|unique:stations,name,'. $station->id,
            'address' => 'required',
        ]);
        $station->update([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
        ]);
        notify()->success('Station Successfully Updated.', 'Added');
        return redirect()->route('admin.stations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Station $station
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Station $station)
    {
        $station->delete();
        notify()->success("Station Successfully Deleted", "Deleted");
        return back();
    }
}
