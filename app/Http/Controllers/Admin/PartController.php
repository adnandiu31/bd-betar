<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PartExport;
use App\Http\Controllers\Controller;
use App\Imports\PartImport;
use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartCreate;
use App\Models\PartType;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('parts');
        return view('backend.parts.index', [
            'parts' => Part::filter()->checkStation()->with('partType', 'manufacture','instrument')->latest('id')->paginate(10),
            'partTypes' => PartType::all(),
            'manufactures' => Manufacture::all(),
            'instruments' => Instrument::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('backend.parts.form', [
        //     'instruments' => Instrument::filter()->checkStation()->latest('id')->get(),
        //     'partTypes' => PartType::all(),
        //     'parts' => Part::filter()->checkStation()->latest('id')->get(),
        //     'manufactures' => Manufacture::latest('id')->get()
        // ]);

        $instruments = Instrument::filter()->checkStation()->latest('id')->get();
        $partTypes = PartType::latest('id')->get();
        $parts = Part::filter()->checkStation()->latest('id')->get();
        $manufactures = Manufacture::latest('id')->get();
        return view('backend.parts.create',['instruments'=>$instruments,'partTypes'=>$partTypes,'manufactures'=>$manufactures]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id != null) {
            $this->validate($request, [
                'part_id' => 'nullable|unique:parts',
                'name' => 'required|string',
                'quantity' => 'nullable',
                'newquantity'=>'required|integer',
            ]);

            $part = Part::findOrFail($request->id);
            $part->update([
                'name' => $request->name,
                'quantity' => $part->quantity + $request->newquantity
            ]);
            notify()->success('Part Updated.', 'Added');
            return ['redirect' => route('admin.parts.index')];
        } else {
            $this->validate($request, [
                'part_id' => 'nullable|unique:parts',
                'name' => 'required|string',
                'instrument_id' => 'nullable',
                'part_type_id' => 'nullable',
                'manufacture_id' => 'nullable',
                'description' => 'nullable',
                'specification' => 'nullable',
                'designation' => 'nullable',
                'parts_no' => 'required|string',
                'purchase_date' => 'nullable',
                'parts_pos' => 'nullable',
                'quantity' => 'nullable',
                'in_use' => 'nullable',
                'present_stock' => 'nullable',
                'comments' => 'nullable',
                'ledger_information' => 'nullable',
                'parts_attached_file' => 'nullable|mimes:pdf',
            ]);

            $stations = Station::all();
            foreach ($stations as $station) {
            $station_code = $station->name;
            if(strlen($station_code) > 2 ) {
                $station_code = substr($station_code, 0, 2);
                $station_code = strtolower($station_code);
            }
            $referal_code = random_int(1000, 999999);
            $part_id = $station_code.'-'. $referal_code;
            $attached_file=$request->file('parts_attached_file');

            if (isset($attached_file)){
                $parts_attached_file= time().'_'.$attached_file->getClientOriginalName();
            }

            Part::create([
                'part_id' => $part_id,
                'name' => $request->get('name'),
                'instrument_id' => $request->get('instrument_id'),
                'station_id' => $station->id,
                'part_type_id' => $request->get('part_type_id'),
                'manufacture_id' => $request->get('manufacture_id'),
                'description' => $request->get('description'),
                'specification' => $request->get('description'),
                'designation' => $request->get('designation'),
                'parts_no' => $request->get('parts_no'),
               'purchase_date' => $request->get('purchase_date'),
                'parts_pos' => $request->get('parts_pos'),
               'quantity' =>(!Auth::user()->isAdmin())?( $station->id == Auth::user()->station->id ? $request->get('quantity') : 00) : $request->get('quantity'),
               'in_use' => $request->get('in_use'),
               'present_stock' => $request->get('present_stock'),
                'comments' => $request->get('comments'),
                'ledger_information' => $request->get('ledger_information'),
                'parts_attached_file'=>$request->hasFile('parts_attached_file')?$request->file('parts_attached_file')->storeAs('AttacheFile',$parts_attached_file):null
            ]);
           }
            notify()->success('Part Added.', 'Added');
            return ['redirect' => route('admin.parts.index')];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Part $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Part $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part,Station $station)

    {
        // dd($station);
        return view('backend.parts.form', [
            'part' => $part,
            'instruments' => Instrument::latest('id')->get(),
            'partTypes' => PartType::all(),
            'manufactures' => Manufacture::latest('id')->get(),
            'parts' => Part::filter()->checkStation()->latest('id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Part $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        // dd($request);
        $this->validate($request, [
            'part_id' => 'nullable',
            'name' => 'nullable',
            'instrument' => 'nullable',
//            'station' => 'nullable',
            'type' => 'nullable',
            'manufacture' => 'nullable',
//            'quantity' => 'nullable',
        ]);

        $attached_file=$request->file('parts_attached_file');

        if (isset($attached_file)){
            $parts_attached_file= time().'_'.$attached_file->getClientOriginalName();
        }

        $part->update([
            'part_id' => $part->part_id,
            'name' => $request->get('name'),
            'instrument_id' => $request->get('instrument'),
            'station_id' => $part->station_id,
            'part_type_id' => $request->get('part_type'),
            'manufacture_id' => $request->get('manufacture'),
            'description' => $request->get('description'),
            'specification' => $request->get('description'),
            'designation' => $request->get('designation'),
            'parts_no' => $request->get('parts_no'),
           'purchase_date' => $request->get('purchase_date'),
            'parts_pos' => $request->get('parts_pos'),
           'quantity' => $request->get('quantity'),
           'in_use' => $request->get('in_use'),
           'present_stock' => $request->get('present_stock'),
            'comments' => $request->get('comments'),
            'ledger_information' => $request->get('ledger_information'),
            'parts_attached_file'=>$request->hasFile('parts_attached_file')?$request->file('parts_attached_file')->storeAs('AttacheFile',$parts_attached_file):$part->parts_attached_file ,
        ]);

        // dd('done');
        notify()->success('Part Updated.', 'Updated');
        return redirect()->route('admin.parts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Part $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        $part->delete();
        notify()->success("Part Deleted", "Deleted");
        return back();
    }

    public function getPartByInstrument($id)
    {
        $parts = Part::filter()->checkStation()->where('instrument_id',$id)->get();
        echo json_encode($parts);
    }

    public function getPartByType($id)
    {
        $parts = Part::filter()->checkStation()->where('part_type_id',$id)->get();
        echo json_encode($parts);
    }

    public function autoComplete (Request $request) {
        if($request->get('query')) {
            $query = $request->get('query');
            // dd($query);
            $data = Part::checkStation()->select('name','id')->where('name','LIKE',"%{$query}%")->get();
            if($data->count() > 0) {
                $output = '<ul class="dropdown-menu">';
                // $output = '<a class="" href="#">This is test</a>';
                foreach($data as $row)
                {
                    $output .= '<li><a href="/admin/parts/'.$row->id.'/edit ">'.$row->name.'</a></li>';
                }
                $output .= '</ul>';
                echo $output;
            }
            // else {
            //     $notFound = "<p class='no-data'>No data found </p>";
            //     echo  $notFound;
            // }

        }
    }
    // Method for import file
    public function storeImport(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);
        // dd($request->file('file'));

        Excel::import(new PartImport(), $request->file('file'));
        notify()->success('Imported Successfully', 'Added');
        return redirect()->route('admin.parts.index');
    }

    public function export()
    {
        return Excel::download(new PartExport, 'parts-' . Carbon::parse()->toDateString() . '.xlsx');
    }

    // Test purpose
    public function partCreate () {
        $instruments = Instrument::filter()->checkStation()->latest('id')->get();
        $partTypes = PartType::latest('id')->get();
        $parts = Part::filter()->checkStation()->latest('id')->get();
        $manufactures = Manufacture::latest('id')->get();
        return view('backend.parts.create',['instruments'=>$instruments,'partTypes'=>$partTypes,'manufactures'=>$manufactures]);
    }

    public function submitData (Request $request) {


        $this->validate($request, [
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'position' => 'required|string',
            'designation' => 'required|string',
        ]);

        if($request->id != null) {
            $part = PartCreate::findOrFail($request->id);
            $part->update([
                'quantity' => $part->quantity + $request->quantity
            ]);
            return response()->json(['success'=>'post updated successfully']);
        }else {
            PartCreate::create([
                'name' => $request->get('name'),
                'quantity' => $request->get('quantity'),
                'position' => $request->get('position'),
                'designation' => $request->get('designation'),
            ]);
            return response()->json(['success'=>'post created successfully']);
        }

    }

    public function getData (Request $request) {
        $query = $request->name;
        if($query != "" && $query != null) {
            $data = Part::checkStation()->where('name','LIKE',"%{$query}%")->get();
            return response()->json($data);
        }
    }

    public function getSingleData ($id) {
        $singleData = Part::checkStation()->where('id',$id)->with('instrument','partType','manufacture')->first();
        return response()->json($singleData);
    }
}
