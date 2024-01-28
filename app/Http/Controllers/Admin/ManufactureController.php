<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacture;
use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.manufactures.index', [
            'manufactures' => Manufacture::latest('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.manufactures.form');
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
            'name' => 'required|unique:manufactures',
            'country' => 'nullable',
            'address' => 'nullable',
        ]);
        Manufacture::create([
            'name' => $request->get('name'),
            'country' => $request->get('country'),
            'address' => $request->get('address'),
        ]);
        notify()->success('Manufacture Successfully Added.', 'Added');
        return redirect()->route('admin.manufactures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Manufacture $manufacture
     * @return \Illuminate\Http\Response
     */
    public function show(Manufacture $manufacture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Manufacture $manufacture
     * @return \Illuminate\View\View
     */
    public function edit(Manufacture $manufacture)
    {
        return view('backend.manufactures.form',compact('manufacture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manufacture $manufacture
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Manufacture $manufacture)
    {
        $this->validate($request, [
            'name' => 'required|unique:manufactures,name,'. $manufacture->id,
            'country' => 'required',
            'address' => 'required',
        ]);
        $manufacture->update([
            'name' => $request->get('name'),
            'country' => $request->get('country'),
            'address' => $request->get('address'),
        ]);
        notify()->success('Manufacture Successfully Added.', 'Added');
        return redirect()->route('admin.manufactures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Manufacture $manufacture
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Manufacture $manufacture)
    {
        $manufacture->delete();
        notify()->success("Manufacture Successfully Deleted", "Deleted");
        return back();
    }
}
