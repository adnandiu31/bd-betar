<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reply;
use App\Models\Forum;

class ReplyController extends Controller
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
        $request->validate([
            'forum_id'=>'required',
            'reply'=>'required'
        ]);
        $forum=Forum::findOrFAil($request->forum_id);
       //dd($request->reply);
        if($forum){
            $forum->replies()->create([
                'reply'=>$request->reply,
                'user_id'=>auth()->user()->id
                ]);
            notify()->success('Reply posted','posted');
            return redirect()->route('forum.show',$forum->id);
        }else{
            return back();
        }
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
          //
          $reply=Reply::findOrFail($id);
          if($reply->user->id==auth()->user()->id){
              $reply->delete();
              notify()->success('Reply Deleted','Deleted');
              return redirect()->route('forum.show',$reply->forum->id);
          }else{
              return back();
          }
      }
}
