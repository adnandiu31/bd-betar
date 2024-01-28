<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Forum;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('forum.index',['questions'=>Forum::latest()->paginate('10')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('forum.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'question'=>['required','max:200']
        ]);
        Forum::create([
            'user_id'=>auth()->user()->id,
            'question'=>$request->question,
        ]);

        notify()->success('New forum question added','Added');
        return redirect()->route('forum.index');
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
        $question=Forum::findOrFAil($id);
            return view('forum.details',['question'=>$question]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question=Forum::findOrFail($id);
        if($question->user->id==auth()->user()->id){
            return view('forum.form',['question'=>$question]);
        }else{
            return back();
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $question=Forum::findOrFail($id);
        if($question->user->id==auth()->user()->id){
            $request->validate([
                'question'=>['required','max:200']
            ]);
            $question->update([
                'user_id'=>auth()->user()->id,
                'question'=>$request->question,
            ]);

            notify()->success('Question updated','Updated');
            return redirect()->route('forum.index');
        }else{
            return back();
        }


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
        $question=Forum::findOrFail($id);
        if($question->user->id==auth()->user()->id){
            $question->delete();
            notify()->success('Question Deleted','Deleted');
            return redirect()->route('forum.index');
        }else{
            return back();
        }
    }
}
