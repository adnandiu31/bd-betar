<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\Controller;

use App\Models\SibPart;
use Illuminate\Http\Request;

class SibPartController extends Controller
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
     * @param  \App\SibPart  $sibPart
     * @return \Illuminate\Http\Response
     */
    public function show(SibPart $sibPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SibPart  $sibPart
     * @return \Illuminate\Http\Response
     */
    public function edit(SibPart $sibPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SibPart  $sibPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SibPart $sibPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SibPart  $sibPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(SibPart $sibPart)
    {
        //
    }
    public function updateQuantity(Request $request,SibPart $sibPart)
    {
        $request->validate([
            'quantity'=>'required|integer|min:1|between:1,'.$sibPart->part->quantity

        ]);
            $sibPart->update([
                'quantity'=>$request->quantity
            ]);
            notify()->success("Quantity Updated", "Updated");
        return back();
    }
}
