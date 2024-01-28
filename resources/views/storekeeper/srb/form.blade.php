@extends('layouts.app')

@section('title','Srb')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
                SRB Request Details
            </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item mr-2">
                    <p>
                        <strong>Date:</strong> {{ $srb->date }} <br>
                        <strong>Status:</strong>
                        @if($srb->status == true)
                            <span class="badge badge-success">Submitted</span>
                        @else
                            <span class="badge badge-danger">Draft</span>
                        @endif
                    </p>
                </li>
                <li class="nav-item mr-2">
                    <form method="post" action="{{ route('storekeeper.srb.changeStatus',$srb->id) }}">
                        @csrf
                        @if(!$srb->approved_by_si_at)
                            <button type="submit" class="btn {{ $srb->status == true ? 'btn-danger' : 'btn-success' }}">
                                Mark as {{ $srb->status == true ? 'Draft' : 'Submit' }}
                            </button>
                        @endif
                    </form>
                </li>
                <li class="nav-item">
                    <a href="{{ route('storekeeper.srb.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="mdi mdi-arrow-left"></i>
                    </span>
                        Back to list
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning" role="alert">
                    {{ $error }}
                 </div>
             @endforeach
             <div class="main-card mb-3 card" >
                 <div class="table-responsive">
                     @if($srb->indent->product_type === 'instrument')
                         <table  class="align-middle mb-0 table table-borderless table-hover">
                             <thead>
                             <tr>
                                 <th class="text-center">#</th>
                                 <th class="text-center">ID</th>
                                 <th class="text-center">Name</th>
                                 <th class="text-center">Type</th>
                                 <th class="text-center">Manufacturer</th>
                                 <th class="text-center">Quantity</th>
                                 <th class="text-center">Received</th>
                                 @if($srb->status)
                                     <th class="text-center">Remaining</th>
                                 @else
                                     <th class="text-center">Action</th>
                                 @endif
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($srb->instruments as $key=>$srbInstrument)
                                 <tr>
                                     <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $srbInstrument->instrument->instrument_id ?? null }}</td>
                                    <td class="text-center">{{ $srbInstrument->instrument->name ?? null }}</td>
                                    <td class="text-center">{{ $srbInstrument->instrument->instrumentType->name ?? null }}</td>
                                    <td class="text-center">{{ $srbInstrument->instrument->manufacture ? $srbInstrument->instrument->manufacture->name : '' }}</td>
                                    <td class="text-center">{{ $srbInstrument->quantity ?? null }}</td>
                                     @if($srb->status)
                                         <td class="text-center">{{ $srbInstrument->unit }}</td>
                                         <td class="text-center">{{ $srbInstrument->remaining }}</td>
                                     @else
                                         <td class="text-center">
                                             <form id="updateInstrument-{{$srbInstrument->id}}" action="{{route('storekeeper.srb.instrument.store',['srb'=>$srb->id,'instrument'=>$srbInstrument->id])}}" method="POST">
                                                 @csrf
                                                 <input name="unit" type="number" class="form-control" value="{{ $srbInstrument->unit }}">
                                             </form>
                                         </td>
                                         <td>
                                             <button onclick="document.getElementById('updateInstrument-{{$srbInstrument->id}}').submit()" type="button" class="btn btn-danger btn-sm"
                                             >
                                                 <span>{{$srbInstrument->unit>0?'Updated':'Update'}}</span>
                                             </button>
                                         </td>
                                     @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Instrument</th>
                                <th class="text-center">Manufacturer</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Received</th>
                                @if($srb->status)
                                    <th class="text-center">Remaining</th>
                                @else
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($srb->parts as $key=>$srbPart)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $srbPart->part->name ?? null }}</td>
                                    <td class="text-center">{{ $srbPart->part->partType->name ?? null }}</td>
                                    <td class="text-center">{{ $srbPart->part->instrument->name  ?? null}}</td>
                                    <td class="text-center">{{ $srbPart->part->manufacture ? $srbPart->part->manufacture->name : '' }}</td>
                                    <td class="text-center">{{ $srbPart->quantity }}</td>
                                    @if($srb->status)
                                        <td class="text-center">{{ $srbPart->unit }}</td>
                                        <td class="text-center">{{ $srbPart->remaining }}</td>
                                    @else
                                        <td class="text-center">
                                            <form id="updatePart-{{$srbPart->id}}" action="{{route('storekeeper.srb.part.store',['srb'=>$srb->id,'part'=>$srbPart->id])}}" method="POST">
                                                @csrf
                                                <input name="unit" type="number" class="form-control" value="{{ $srbPart->unit }}">
                                            </form>
                                        </td>
                                        <td>
                                            <button onclick="document.getElementById('updatePart-{{$srbPart->id}}').submit()" type="button" class="btn btn-danger btn-sm"
                                            >
                                                <span>{{$srbPart->unit>0?'Updated':'Update'}}</span>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
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
