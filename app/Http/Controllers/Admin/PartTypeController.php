<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.part-types.index', [
            'partTypes' => PartType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.part-types.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:part_types'
        ]);
        PartType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        notify()->success('Part Type Added.', 'Added');
        return redirect()->route('admin.part-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PartType $partType
     * @return \Illuminate\Http\Response
     */
    public function show(PartType $partType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\PartType $partType
     * @return
     * \Illuminate\View\View
     */
    public function edit(PartType $partType)
    {
        return view('backend.part-types.form', compact('partType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PartType $partType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PartType $partType)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:part_types,name,' . $partType->id
        ]);
        $partType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        notify()->success('Part Type Updated.', 'Updated');
        return redirect()->route('admin.part-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PartType $partType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PartType $partType)
    {
        $partType->delete();
        notify()->success("Part Type Deleted", "Deleted");
        return back();
    }
}
