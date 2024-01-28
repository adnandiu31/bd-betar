<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use App\Models\Station;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.ledgers.index', [
            'ledgers' => Ledger::latest('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.ledgers.form', [
            'stations' => Station::all()
        ]);
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
            'station' => 'required',
            'address' => 'required',
        ]);
        Ledger::create([
            'station_id' => $request->get('station'),
            'address' => $request->get('address'),
        ]);
        notify()->success('Ledger Successfully Added.', 'Added');
        return redirect()->route('admin.ledgers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ledger $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Ledger $ledger
     * @return \Illuminate\View\View
     */
    public function edit(Ledger $ledger)
    {
        return view('backend.ledgers.form', [
            'stations' => Station::all(),
            'ledger' => $ledger
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ledger $ledger
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Ledger $ledger)
    {
        $this->validate($request, [
            'station' => 'required',
            'address' => 'required',
        ]);
        $ledger->update([
            'station_id' => $request->get('station'),
            'address' => $request->get('address'),
        ]);
        notify()->success('Ledger Successfully Updated.', 'Added');
        return redirect()->route('admin.ledgers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ledger $ledger
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Ledger $ledger)
    {
        $ledger->delete();
        notify()->success("Station Successfully Deleted", "Deleted");
        return back();
    }
}
