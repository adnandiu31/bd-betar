<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('faqs.index', [
            'faqs' => Faq::latest('id')->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.faqs.create');
        return view('faqs.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.faqs.create');
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required|string'
        ]);
        Faq::create([
            'question' => $request->get('question'),
            'answer' => $request->get('answer')
        ]);
        notify()->success('Faq Question Added.', 'Added');
        return redirect()->route('faqs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        Gate::authorize('app.faqs.edit');
        return view('faqs.form',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        Gate::authorize('app.faqs.edit');
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required|string'
        ]);
        $faq->update([
            'question' => $request->get('question'),
            'answer' => $request->get('answer')
        ]);
        notify()->success('Faq Question Updated.', 'Updated');
        return redirect()->route('faqs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        Gate::authorize('app.faqs.destroy');
        $faq->delete();
        notify()->success("Faq Question Deleted", "Deleted");
        return back();
    }
}
