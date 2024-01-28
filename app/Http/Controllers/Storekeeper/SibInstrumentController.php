<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\Controller;
use App\Models\Sib;
use App\Models\SibInstrument;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
class SibInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SibInstrument  $sibInstrument
     * @return \Illuminate\Http\Response
     */
    public function show(SibInstrument $sibInstrument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SibInstrument  $sibInstrument
     * @return \Illuminate\Http\Response
     */
    public function edit(SibInstrument $sibInstrument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SibInstrument  $sibInstrument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SibInstrument $sibInstrument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SibInstrument  $sibInstrument
     * @return \Illuminate\Http\Response
     */
    public function destroy(SibInstrument $sibInstrument)
    {
        //
    }

    public function updateQuantity(Request $request, $sibInstrument)
    {
        $sibInstrument=SibInstrument::where('id',$sibInstrument)->first();
        $request->validate([
            'quantity'=>'required|integer|min:1|between:1,'.$sibInstrument->instrument->quantity

        ]);
            $sibInstrument->update([
                'quantity'=>$request->quantity
            ]);
            notify()->success("Quantity Updated", "Updated");
        return back();
    }
}
