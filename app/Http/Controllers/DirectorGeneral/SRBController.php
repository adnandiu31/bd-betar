<?php

namespace App\Http\Controllers\DirectorGeneral;

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
        $srbs = Srb::status()
            ->where('approved_by_me_at','!=', null)
            ->latest()
            ->get();
        return view('directorGeneral.srb.index',compact('srbs'));
    }

    public function show($id)
    {
        $data['srb'] = Srb::status()->findOrFail($id);
        return view('directorGeneral.srb.show', $data);
    }

    public function changeStatus($srb)
    {
        $srb = Srb::status()->findOrFail($srb);
        $srb->update([
            'approved_by_dg_at' => isset($srb->approved_by_dg_at) ? null: now()
        ]);
        notify()->success("SRB Status Changed", "Success");
        return back();
    }

}
