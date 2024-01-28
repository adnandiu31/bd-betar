<?php

namespace App\Http\Controllers\IntentOfficer;

use App\Http\Controllers\Controller;
use App\Mail\IndentMail;
use App\Models\Indent;
use App\Models\Instrument;
use App\Models\InstrumentIndent;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartIndent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PDF;

// use Spatie\MediaLibrary\Conversions\ImageGenerators\Pdf as ImageGeneratorsPdf;

class IndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indents = Indent::latest('id')->checkStation()->get();
        $manufacture = Manufacture::select('id','name')->latest('id')->get();
        return view('intentOfficer.indents.index', compact('indents','manufacture'));
    }

    // Generate PDF
    public function createPDF($indent)
    {
        $data['indent'] = Indent::checkStation()->findOrFail($indent);

        $roleSlugsOne = ['station-incharge', 'station-head'];
        $roleSlugsTwo = ['central-engineer','main-engineer','director-general'];
        $roleIdsForStation = Role::whereIn('slug', $roleSlugsOne)->pluck('id')->toArray();
        $roleIdsWithoutStation = Role::whereIn('slug', $roleSlugsTwo)->pluck('id')->toArray();
        $stationUsers = User::checkStation()->whereIn('role_id', $roleIdsForStation)->with('role','station')->get()->toArray();
        $globalUsers = User::whereIn('role_id', $roleIdsWithoutStation)->with('role','station')->get()->toArray();
        $data['users'] = array_merge($stationUsers, $globalUsers);

//         return view('intentOfficer.indents.export', $data);
        $pdf = PDF::loadView('intentOfficer.indents.export', $data);

        // download PDF file with download method
        return $pdf->download('Indent.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'date' => 'required|date',
            'manufacture_id' => 'required',
            'type' => 'required|string',
            'form' => 'required|in:A,B,C',
            'economic_code' => 'required'
        ]);
        $station = Auth::user()->station->name;
        $firstThreeLetters = substr($station, 0, 3);
        $indent = Indent::create([
            'station_id' => Auth::user()->station->id,
            'product_type' => $request->type,
            'manufacture_id' => $request->manufacture_id,
            'date' => $request->date,
            'name' => $request->name,
            'note' => $request->note,
            'form' => $request->form,
            'economic_code' => $request->economic_code,
            'indent_id' => $firstThreeLetters.'-'.$request->type.'-'.rand(0,99999)
        ]);

        $role = Role::where(['slug' => 'station-incharge'])->first();
        $stationIncharge = User::checkStation()->where(['role_id' => $role->id])->first();
        // $mailData = [
        //     'name' => $stationIncharge->name,
        //     'url' => env('APP_URL').'/station-incharge/indents',
        // ];
        // Mail::to($stationIncharge->email)->send(new IndentMail($mailData));

        return redirect()->route('intentOfficer.indents.edit', $indent->id);
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['indent'] = Indent::checkStation()->findOrFail($id);
        return view('intentOfficer.indents.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['indent'] = Indent::checkStation()->findOrFail($id);
        $manufacture_id = $data['indent']->manufacture_id;

        if ($data['indent']->product_type === 'instrument') {
            $data['instruments'] = Instrument::checkStation()->latest()->get();

        } else {
            $data['parts'] = Part::where('manufacture_id',$manufacture_id)->checkStation()->latest()->get();
        }

        // dd($data);
        return view('intentOfficer.indents.form', $data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Indent::checkStation()->findOrFail($id)->delete();
        notify()->success("Indent Deleted", "Deleted");
        return back();
    }

    public function addNewProduct(Request $request, $indentId)
    {
        $this->validate($request, [
            'product' => 'required',
            'quantity' => 'required'
        ]);
        $indent = Indent::checkStation()->findOrFail($indentId);

        if ($indent->product_type === 'instrument') {
            InstrumentIndent::create([
                'indent_id' => $indent->id,
                'instrument_id' => $request->product,
                'quantity' => $request->quantity,
                'remaining' => $request->quantity
            ]);
        } else {
            PartIndent::create([
                'indent_id' => $indent->id,
                'part_id' => $request->product,
                'quantity' => $request->quantity,
                'remaining' => $request->quantity
            ]);
        }
        return redirect()->back();
    }

    public function deleteProduct($indentId, $productId)
    {
        $indent = Indent::checkStation()->findOrFail($indentId);

        if ($indent->product_type === 'instrument') {
            InstrumentIndent::findOrFail($productId)->delete();
        } else {
            PartIndent::findOrFail($productId)->delete();
        }
        notify()->success("Product Removed", "Removed");
        return back();
    }

    public function changeStatus($indentId)
    {
        $indent = Indent::checkStation()->findOrFail($indentId);
        $indent->update([
            'status' => $indent->status == true ? false : true
        ]);
        notify()->success("Indent Status Changed", "Success");
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function getParts($typeId)
    {

        return Part::whereHas('stockParts', function (Builder $query) {
            $query->where('station_id', Auth::user()->station->id);
        })->where('part_type_id', $typeId)->get();
    }

    public function getInstrument($typeId)
    {

        return Instrument::whereHas('stockInstruments', function (Builder $query) {
            $query->where('station_id', Auth::user()->station->id);
        })->where('instrument_type_id', $typeId)->get();
    }
}
