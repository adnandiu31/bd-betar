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
                SIB Request ({{ ucfirst($sib->product_type) }})
            </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item mr-2">
                    <p>
                        <!-- <strong>Date:</strong> {{ $sib->date }} <br> -->
                        <strong>Status:</strong>
                        @if($sib->status == true)
                            <span class="badge badge-success">Submitted</span>
                        @else
                            <span class="badge badge-danger">Draft</span>
                        @endif
                    </p>
                </li>
                <li class="nav-item mr-2">
                    <form method="post" action="{{ route('storekeeper.sib.changeStatus',$sib->id) }}">
                        @csrf
                        <button type="submit" class="btn {{ $sib->status == true ? 'btn-danger' : 'btn-success' }}">
                            Mark as {{ $sib->status == true ? 'Draft' : 'Submit' }}
                        </button>
                    </form>
                </li>
                <li class="nav-item">
                    <a href="{{ route('storekeeper.sib.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="mdi mdi-arrow-left"></i>
                    </span>
                        Back to list
                    </a>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn " style="background-color: #2c6140; color:white;" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add {{ $sib->product_type === 'instrument' ? 'Instrument' : 'Part' }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New sib Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="userFrom" action="{{ route('storekeeper.sib.addNewProduct',$sib->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                            <x-forms.select label="Select Product"
                                            id="product"
                                            name="product"
                                            class="select js-example-basic-single">
                                @if($sib->product_type === 'part')
                                    <option selected disabled></option>
                                    @foreach($parts as $part)
                                        <option value="{{$part->id}}">{{$part->name .' '.$part->parts_no}}</option>
                                    @endforeach
                                @else
                                    <option selected disabled></option>
                                    @foreach($instruments as $instrument)
                                        <option value="{{$instrument->id}}">{{$instrument->name}}</option>
                                    @endforeach
                                @endif
                            </x-forms.select>

                        <input type="hidden" name="sib_id" value="{{$sib->id}}">

                        <x-forms.textbox label="Quantity"
                                         type="number"
                                         name="quantity"
                                         field-attributes="required">
                        </x-forms.textbox>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn customButton">Submit</button>
                    </div>
                </form>
            </div>
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
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                @if($sib->product_type === 'instrument')
                        <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Manufacturer</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sib->instruments as $key=>$sibInstrument)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $sibInstrument->instrument->instrument_id ?? null }}</td>
                                    <td class="text-center">{{ $sibInstrument->instrument->name ?? null }}</td>
                                    <td class="text-center">{{ $sibInstrument->instrument->instrumentType->name ?? null }}</td>
                                    <td class="text-center">{{ $sibInstrument->instrument->manufacture->name ?? null }}</td>
                                    <td class="text-center">{{ $sibInstrument->quantity }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $sibInstrument->id }})">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Remove</span>
                                        </button>

                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#quantityModal-{{$sibInstrument->id}}">
                                            <i class="mdi mdi-pencil"></i>
                                                        <span>Update Quantity</span>
                                        </a>

                                        <!-- Update quantity modal -->
                                        <div class="modal fade" id="quantityModal-{{$sibInstrument->id}}" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="quantityModalLabel">Update Quantity</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ $sib->product_type === 'instrument'?route('storekeeper.sib.instrument.quantity.update',$sibInstrument->id):route('storekeeper.sib.parts.quantity.update',$sibInstrument->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <x-forms.textbox label="Quantity"
                                                                                type="number"
                                                                                name="quantity"
                                                                                field-attributes="required">
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
                                        <!-- Update quantity modal end -->
                                        <form id="delete-form-{{ $sibInstrument->id }}"
                                              action="{{ route('storekeeper.sib.product.delete',['sibId'=>$sib->id,'productId'=>$sibInstrument->id]) }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Names</th>

                                <th class="text-center">Types</th>
                                <th class="text-center">Manufacturer</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sib->parts as $key=>$sibPart)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    {{-- <td class="text-center"> <a href="{{route('storekeeper.sib.part.instruments',$sibPart->part->part->id)}}"> {{ $sibPart->part->part->id }} </a></td> --}}
                                    {{-- <td class="text-center"> <a href="{{route('storekeeper.sib.part.instruments',$sibPart->part->id)}}"> {{ $sibPart->part->part->name }} </a></td> --}}
                                    <td class="text-center"> {{ $sibPart->part->name ?? null }} </td>
                                    <td class="text-center">{{ $sibPart->part->partType->name ?? null }}</td>
                                    <td class="text-center">{{ $sibPart->part->manufacture->name ?? null }}</td>
                                    <td class="text-center">{{ $sibPart->quantity ?? null }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $sibPart->id }})">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Delete</span>
                                        </button>
                                        <form id="delete-form-{{ $sibPart->id }}"
                                              action="{{ route('storekeeper.sib.product.delete',['sibId'=>$sib->id,'productId'=>$sibPart->id]) }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#quantityPart-{{$sibPart->id}}"
                                                   ><i
                                                            class="mdi mdi-pencil"></i>
                                                        <span>Update Quantity</span>
                                        </a>

                                        {{-- <a href="{{route('storekeeper.sib.part.instruments',$sibPart->id)}}" class="btn btn-info btn-sm" >
                                            <i class="mdi mdi-plus"></i>
                                                <span>Add Instrumentsss</span>
                                                {{$sibPart->id}}
                                        </a> --}}
                                        <!-- Update quantity modal -->
                                        <div class="modal fade" id="quantityPart-{{$sibPart->id}}" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="quantityModalLabel">Update Quantity</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{route('storekeeper.sib.parts.quantity.update',$sibPart->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <x-forms.textbox label="Quantity"
                                                                             type="number"
                                                                             name="quantity"
                                                                             field-attributes="required">
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
                                        <!-- Update quantity modal end -->
                                    </td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Datatable
            $("#datatable").DataTable();
        });

        $(document).ready(function() {
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#product').select2({
                    dropdownParent: $('#exampleModal'),
                    placeholder: 'Select an option'
                });
            });
        });
    </script>
@endpush
