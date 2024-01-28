<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Troubleshooting;

class TroubleshootingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('troubleshooting.index',['troubleshootings'=>Troubleshooting::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('troubleshooting.form');
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
        $attributes=$this->troubleshootValidator($request);

        $attributes['repair_id']=rand(100000,10000000);
        //dd($attributes);
        Troubleshooting::create($attributes);
        notify()->success('Troubleshooting Created','Added');
        return redirect()->route('troubleshootings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $troubleshoot=Troubleshooting::findOrFail($id);

        return view('troubleshooting.details',['troubleshoot'=>$troubleshoot]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $troubleshoot=Troubleshooting::findOrFail($id);
        return view('troubleshooting.form',['troubleshoot'=>$troubleshoot]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $attributes=$this->troubleshootValidator($request);
        $troubleshoot=Troubleshooting::findOrFail($id);
        $troubleshoot->update($attributes);
        notify()->success('Troubleshoot updated','Updated');
        return redirect()->route('troubleshootings.edit',$troubleshoot->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $troubleshoot=Troubleshooting::findOrFail($id);
        $troubleshoot->delete();
        notify()->success('Troubleshoot deleted','Deleted');
        return redirect()->route('troubleshootings.index');
    }

    private function troubleshootValidator($request){

        
        return $request->validate([
            'product_name'=>'required',
            'date'        =>'required',
            'fault'       =>'required',
            'fault_location'  =>'required',
            'symptom'=>'required',
            'solution'=>'required',
            'station_name'=>'required',
            'author'=>'required',
            'designation'=>'required',
            'mobile_number'=>'required',
            'email'=>'required'
        ]);
    }
}
