<?php

namespace App\Http\Controllers\StationHead;

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
            ->checkStation()
            ->where('approved_by_si_at','!=', null)
            ->latest()
            ->get();
        return view('stationHead.srb.index',compact('srbs'));
    }

    public function show($id)
    {
        $data['srb'] = Srb::checkStation()->findOrFail($id);
        return view('stationHead.srb.show', $data);
    }

    public function changeStatus($srb)
    {
        $srb = Srb::status()->checkStation()->findOrFail($srb);
        $srb->update([
            'approved_by_sh_at' => isset($srb->approved_by_sh_at) ? null: now()
        ]);
        notify()->success("SRB Status Changed", "Success");
        return back();
    }

}
