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
              </span> PART</h3>
        </div>
        {{-- {{$sibPart->quantity}} --}}
        {{-- @if ($sibPart->quantity > $parts->count())

        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Instrumentssss
                    </button>
                </li>
            </ul>
        </div>
        @endif --}}
    </div>
@endsection

 {{-- Modal --}}
 @section('modal')
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">New Instruments Requests</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form method="POST" action="{{ route('storekeeper.sib.part.addInstruments',$stockPart->id) }}">
                 @csrf
                 <div class="modal-body">
                     <x-forms.select label="Intruments"
                                     name="instrument"
                                     class="">
                         @foreach ($stockInstruments as $stockInstrument)
                            <x-forms.select-item value="{{$stockInstrument->id}}" label="{{$stockInstrument->instrument->name}}" selected />
                         @endforeach
                     </x-forms.select>

                     <x-forms.textbox label="Designation"
                                        name="designation"
                                        value=""
                                        field-attributes="required autofocus">
                    </x-forms.textbox>
                    <input type="hidden" name="part_id" value="{{$stockPart->id}}">
                    <input type="hidden" name="sib_part_id" value="{{$sibPart->id}}">
                    <x-forms.textbox label="Part no"
                                        name="part_no"
                                        value=""
                                        field-attributes="required autofocus">
                    </x-forms.textbox>
                    <x-forms.textbox label="Part position"
                                        name="part_position"
                                        value=""
                                        field-attributes="required autofocus">
                    </x-forms.textbox>
                    <x-forms.textbox label="Ledger Info"
                                        name="ledger_info"
                                        value=""
                                        field-attributes="required autofocus">
                    </x-forms.textbox>
                    <x-forms.textbox label="Usage Name"
                                        name="usage_name"
                                        value=""
                                        field-attributes="required autofocus">
                    </x-forms.textbox>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
@endsection
{{-- Modal End   --}}

@section('content')
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parts as $key=>$instrument)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $instrument->stockInstrument->instrument->name ?? null }}</td>
                                <td class="text-center">{{ $instrument->designation ?? null }}</td>
                                <td class="text-center">{{ $instrument->part_no ?? null }}</td>
                                <td class="text-center">{{ $instrument->part_pos ?? null }}</td>
                                <td class="text-center">{{ $instrument->ledger_info ?? null }}</td>
                                <td class="text-center">{{ $instrument->usage_name ?? null }}</td>
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
