<?php

namespace App\Http\Controllers\IntentOfficer;

use App\Http\Controllers\Controller;
use App\Models\Indent;
use App\Models\Srb;
use App\Models\SrbInstrument;
use App\Models\SrbPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SRBController extends Controller
{
    public function index()
    {
        $srbs = Srb::checkStation()->get();
        $indents = Indent::allApproved()->get();
        return view('intentOfficer.srb.index',compact('srbs','indents'));
    }

    public function edit($id)
    {
        $srb = Srb::findOrFail($id);
        return view('intentOfficer.srb.form',compact('srb'));
    }

//    public function changeStatus($srb)
//    {
//        $srb = Srb::checkStation()->findOrFail($srb);
//        $srb->update([
//            'status' => $srb->status == true ? false : true
//        ]);
//        notify()->success("Srb Status Changed", "Success");
//        return back();
//    }

}
