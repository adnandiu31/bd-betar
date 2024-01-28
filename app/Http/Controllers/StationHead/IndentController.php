<?php

namespace App\Http\Controllers\StationHead;

use App\Http\Controllers\Controller;
use App\Mail\IndentMail;
use App\Models\Indent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndentController extends Controller
{
    public function index()
    {
        $indents = Indent::status()
            ->checkStation()
            ->where('approved_by_si_at','!=', null)
            ->latest('id')
            ->get();
        return view('stationHead.indents.index',compact('indents'));
    }

    public function show($id)
    {
        $data['indent'] = Indent::status()->checkStation()->findOrFail($id);
        return view('stationHead.indents.show',$data);
    }

    public function status($id)
    {
        $indent = Indent::status()->checkStation()->findOrFail($id);
        $indent->update([
            'approved_by_sh_at' => isset($indent->approved_by_sh_at) ? null: now()
        ]);

        $role = Role::where(['slug' => 'central-engineer'])->first();
        $centralEngineer = User::where(['role_id' => $role->id])->first();
        // $mailData = [
        //     'name' => $centralEngineer->name,
        //     'url' => env('APP_URL').'/station-head/indents',
        // ];
        // Mail::to($centralEngineer->email)->send(new IndentMail($mailData));
        notify()->success("Indent Status Changed", "Success");
        return back();
    }
}
