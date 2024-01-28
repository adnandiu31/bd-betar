<?php

namespace App\Http\Controllers\StationIncharge;

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
            ->latest()
            ->get();
        return view('stationIncharge.srb.index',compact('srbs'));
    }

    public function show($id)
    {
        $data['srb'] = Srb::checkStation()->findOrFail($id);
        return view('stationIncharge.srb.show', $data);
    }

    public function changeStatus($srb)
    {
        $srb = Srb::status()->checkStation()->findOrFail($srb);
        $srb->update([
            'approved_by_si_at' => isset($srb->approved_by_si_at) ? null: now()
        ]);
        notify()->success("SRB Status Changed", "Success");
        return back();
    }

}
