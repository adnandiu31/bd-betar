@extends('layouts.app')

@section('title','Parts')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> PARTs</h3>
        </div>
        {{-- <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Instrument
                    </button>
                </li>
            </ul>
        </div> --}}
    </div>
@endsection

 {{-- Modal --}}
 @section('modal')
 {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">New Instruments Request</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form method="POST" action="{{ route('storekeeper.sib.part.addInstruments',$stockPart) }}">
                 @csrf
                 <div class="modal-body">
                     <x-forms.select label="Intrument"
                                     name="instrument"
                                     class="">
                         @foreach ($stockInstruments as $stockInstrument)
                            <x-forms.select-item value="{{$stockInstrument->instrument->id}}" label="{{$stockInstrument->instrument->name}}" selected />
                         @endforeach
                     </x-forms.select>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div> --}}
@endsection
{{-- Modal End   --}}

@section('content')
    {{-- Filter start --}}
    {{-- <div class="row">
        <div class="col-md-12 ">
            <div class="bg-white mx-1 my-4 px-5 py-2 rounded">
               <form action="{{route('storekeeper.stock.parts')}}" method="get">
                    <div class=" d-flex justify-content-around align-items-center py-2 ">

                        <div class="col-md-2">
                            <select name="type" class="custom-select" id="filter">
                                <option  disabled selected>Type</option>
                                @foreach($partTypes as $key=>$partType)
                                    <option>{{ $partType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="instrument" class="custom-select" id="filter">
                                <option  disabled selected>Instrument</option>
                                @foreach($instruments as $key=>$instrument)
                                    <option>{{ $instrument->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="manufacturer" class="custom-select" id="filter">
                                <option disabled selected>Manufacturer</option>
                                @foreach($manufactures as $key=>$manufacture)
                                    <option>{{ $manufacture->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="navbar-form" role="search">
                                <div class="input-group add-on">
                                    <input class="form-control" placeholder="Search" name="search" id="srch-term" type="text">

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex">
                                <div class=" ">
                                    <button type="submit" class="btn btn-info btn-sm py-2"> Filter</button>
                                </div>
                                <div>
                                    <a href="{{route('storekeeper.stock.parts')}}" class="btn btn-warning btn-sm  py-2 ml-2"> Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>

               </form>
            </div>
        </div>
    </div> --}}
    {{-- Filter end --}}


    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Instrument Name</th>
                            <th class="text-center">Designation </th>
                            <th class="text-center">Part No </th>
                            <th class="text-center">Part Position </th>
                            <th class="text-center">Ledger Info </th>
                            <th class="text-center">Usage Name </th>
                            {{-- <th class="text-center">Action</th> --}}
                            {{-- <th class="text-center">Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($stockPart as $key=>$instrument)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $instrument->stockInstrument->instrument->name ?? null }}</td>
                                <td class="text-center">{{ $instrument->designation ?? null }}</td>
                                <td class="text-center">{{ $instrument->part_no ?? null }}</td>
                                <td class="text-center">{{ $instrument->part_pos ?? null }}</td>
                                <td class="text-center">{{ $instrument->ledger_info ?? null }}</td>
                                <td class="text-center">{{ $instrument->usage_name ?? null }}</td>
                                {{-- <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteData({{ $instrument->id }})">
                                <i class="mdi mdi-delete"></i>
                                <span>Delete</span>
                                </button>
                                <form id="delete-form-{{$instrument->id }}"
                                    action="{{ route('storekeeper.sib.part.deleteInstruments',['instrumentId'=>$instrument->id,'partId'=>$stockPart]) }}" method="POST"
                                    style="display: none;">
                                    @csrf()
                                    @method('DELETE')
                                </form>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Datatable
            $("#datatable").DataTable();
        });
    </script>
@endpush
