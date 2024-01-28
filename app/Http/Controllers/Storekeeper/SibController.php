<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\Controller;
use App\Models\DamagePartLog;
use App\Models\Indent;
use App\Models\Role;
use App\Models\Srb;
use App\Models\SibInstrument;
use App\Models\StockInstrument;
use App\Models\SibPart;
use App\Models\Instrument;
use App\Models\StockPart;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartIndent;
use App\Models\PartInstrument;
use App\Models\PartType;
use App\Models\Sib;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
class SibController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sibs = Sib::latest('id')->checkStation()->get();
        return view('storekeeper.sib.index', compact('sibs'));
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
        $this->validate($request, [
            'type' => 'required|string',
        ]);
        $sib = Sib::create([
            'station_id' => Auth::user()->station->id,
            'product_type' => $request->type,
        ]);
        return redirect()->route('storekeeper.sib.edit', $sib->id);
        // return redirect()->route('storekeeper.sib.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sib  $sib
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['sib'] = Sib::checkStation()->findOrFail($id);
        return view('storekeeper.sib.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sib  $sib
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['sib'] = Sib::checkStation()->findOrFail($id);
        $data['roles'] = Role::all();
        if ($data['sib']->product_type === 'instrument') {
            $data['instruments'] = Instrument::checkStation()->get();
        } else {

            $data['parts'] = Part::checkStation()->get();
            // dd($data['parts']);
        }
        return view('storekeeper.sib.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sib  $sib
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sib $sib)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sib  $sib
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sib::checkStation()->findOrFail($id)->delete();
        notify()->success("Sib Request Deleted", "Deleted");
        return back();
    }

    public function addNewProduct(Request $request, $sibId)
    {
        $this->validate($request, [
            'product' => 'required',
            'quantity' => 'required'
        ]);
        $sib = Sib::checkStation()->findOrFail($sibId);
        $sib_id=$request->sib_id;
        if ($sib->product_type === 'instrument') {
            $stock=Instrument::where('id',$request->product)->first();
            if($stock && $stock->quantity<$request->quantity){
                return back()->with('error','Requested quantity not available');
            }
            SibInstrument::create([
                'sib_id' => $request->sib_id,
                'instrument_id' => $request->product,
                'quantity' => $request->quantity
            ]);
        } else {
            // dd($request);
            // $stock=StockPart::where('id',$request->product)->first();
            $stock=Part::where('id',$request->product)->first();
            // dd($stock);
            if($stock && $stock->quantity<$request->quantity){
                return back()->with('error','Requested quantity not available');
            }
            SibPart::create([
                'sib_id' => $request->sib_id,
                'part_id' => $request->product,
                'quantity' => $request->quantity
            ]);
        }
        return redirect()->back();
    }
    public function deleteProduct($sibId, $productId)
    {
        $sib = Sib::checkStation()->findOrFail($sibId);

        if ($sib->product_type === 'instrument') {
            SibInstrument::findOrFail($productId)->delete();
        } else {
            SibPart::findOrFail($productId)->delete();
        }
        notify()->success("Product Removed", "Removed");
        return back();
    }

    public function changeStatus($sibId)
    {
        $sib = Sib::checkStation()->findOrFail($sibId);
        $sib->update([
            'status' => $sib->status == true ? false : true
        ]);
        notify()->success("SIB Status Changed", "Success");
        return back();
    }

    public function adjust($sib){
        $sib=Sib::checkStation()->where('id',$sib)->where('adjust',false)->first();
        if($sib->product_type=='instrument'){
            foreach ($sib->instruments as $sibinstrument) {
                $sibinstrument->instrument->update([
                    'quantity'=>$sibinstrument->instrument->quantity-$sibinstrument->quantity
                ]);
            }
        }else{

            foreach ($sib->parts as $sibpart) {
                $sibpart->part->update([
                    'quantity'=>$sibpart->part->quantity-$sibpart->quantity
                ]);
            }
        }
        notify()->success("Stock Updated", "Updated");
        $sib->update([
            'adjust'=>true
        ]);
        return back();
    }

    public function stockPartInstrumentDetails( $id) {

        // confused in this module

        $stockParts = SibPart::where('id',$id)->first();
        // dd($stockParts);
        // $stockParts = $stockParts->with('stockInstrument')->get();
        // // dd($stockParts);
        // $stockPart = StockPart::checkStation()->findOrFail($id);
        // $sibPart = SibPart::findOrFail($id);
        // dd($sibPart);
        $stockInstruments = StockInstrument::checkStation()->latest('id')->get();
        return view('storekeeper.Stock.partInstruments.index', );

        // ['stockPart' => $stockPart,'parts'=>$stockParts,'stockInstruments'=>$stockInstruments,'sibPart'=>$sibPart]
    }

    public function addInstrumentToPart (Request $request, $id) {

        // dd($request);

        $this->validate($request, [
            'instrument' => 'required',
            'part_id' => 'required',
            'designation' => 'required',
            'part_no' => 'required',
            'part_position' => 'required',
            'ledger_info' => 'required',
            'usage_name' => 'required',
        ]);
        PartInstrument::create([
            'stock_instruments_id' => $request->instrument,
            'stock_parts_id' => $request->part_id,
            'sib_parts_id' => $request->sib_part_id,
            'designation' => $request->designation,
            'part_no' => $request->part_no,
            'part_pos' => $request->part_position,
            'ledger_info' => $request->ledger_info,
            'usage_name' => $request->usage_name,
        ]);
        // $stockPart = PartInstrument::checkStation()->findOrFail($id);


        // $stockPart->stockInstruments()->attach($request->input('instrument',[]));
        // // dd($stockPart);
        notify()->success("Instrument Added", "Success");
        return back();
    }

    public function deleteInstrumentFromPart ( $id) {
        // dd($partId);
        $stockPart = PartInstrument::findOrFail($id);
        $stockPart->delete();
        // $stockPart->stockInstruments()->detach($instrumentId);
        // dd($stockPart);
        notify()->success("Instrument Deleted", "Success");
        return back();
    }

    public function createPDF($sib)
    {
        $data['sib'] = Sib::checkStation()->with('parts')->findOrFail($sib);
        $role = Role::where(['slug' => 'station-incharge'])->first();
        $data['stationInCharge'] = User::checkStation()->where(['role_id' => $role->id])->first();

        $role = Role::where(['slug' => 'station-head'])->first();
        $data['stationHead'] = User::checkStation()->where(['role_id' => $role->id])->first();
//        return view('storekeeper.sib.export',$data);
        $pdf = PDF::loadView('storekeeper.sib.export', $data);

        $name = "sib".rand(0,99999).".pdf";
        // download PDF file with download method
        return $pdf->download($name);
    }

    public function damage()
    {
        $parts = Part::checkStation()->get();
//        return view('backend.damage.form', compact('parts'));
//        $sibs = Sib::latest('id')->checkStation()->get();
        $sibs = DamagePartLog::latest('id')->get();
        return view('storekeeper.damage.index', compact('sibs','parts'));
    }

    public function damageAction(Request $request)
    {
        try {
            $part = Part::where('id',$request->part_id)->first();
            $damage = DamagePartLog::create([
                'part_id' => $request->part_id,
                'quantity' => $request->demage_quantity,
                'entry_time' => now(),
                'user_id' => Auth::user()->id,
                'done_by' => Auth::user()->name,
            ]);
//            dd($damage);
            $reaponse = $part->update([
                'quantity'=>$part->quantity - $request->demage_quantity
            ]);
            notify()->success("Quantity updated", "Success");
            return back();
        } catch (\Exception $exception) {
            Log::error('damageAction error: ',[$exception->getMessage(),$exception->getLine()]);
            notify()->error("Quantity update failed", "Success");
            return back();
        }
    }

}
