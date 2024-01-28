@extends('layouts.app')

@section('title','Indent')


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
                Indent Request ({{ ucfirst($indent->product_type) }})
            </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item mr-2">
                    <p>
                        <strong>Date:</strong> {{ $indent->date }} <br>
                        <strong>Status:</strong>
                        @if($indent->status == true)
                            <span class="badge badge-success">Submitted</span>
                        @else
                            <span class="badge badge-danger">Draft</span>
                        @endif
                    </p>
                </li>
                <li class="nav-item mr-2">
                    <form method="post" action="{{ route('intentOfficer.indents.changeStatus',$indent->id) }}">
                        @csrf
                        <button type="submit" class="btn {{ $indent->status == true ? 'btn-danger' : 'btn-success' }}">
                            Mark as {{ $indent->status == true ? 'Draft' : 'Submit' }}
                        </button>
                    </form>
                </li>
                <li class="nav-item">
                    <a href="{{ route('intentOfficer.indents.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="mdi mdi-arrow-left"></i>
                    </span>
                        Back to list
                    </a>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn customButton" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add {{ $indent->product_type === 'instrument' ? 'Instrument' : 'Part' }}
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
                    <h5 class="modal-title" id="exampleModalLabel">New Indent Request dd</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('intentOfficer.indents.addNewProduct',$indent->id) }}">
                    @csrf
                    <div class="modal-body">
                        <x-forms.select label="Select Product"
                                        id="product"
                                        name="product"
                                        class="select js-example-basic-single">
                            @if($indent->product_type === 'part')
                                <option selected disabled></option>
                                @foreach($parts as $part)
                                    <option value="{{$part->id}}">{{$part->name .' '. $part->parts_no}}</option>
                                @endforeach
                            @else
                                <option selected disabled></option>
                                @foreach($instruments as $instrument)
                                    <option value="{{$instrument->id}}">{{$instrument->name}}</option>
                                @endforeach
                            @endif
                        </x-forms.select>

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
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    @if($indent->product_type === 'instrument')
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
                            @foreach($indent->instruments as $key=>$indentInstrument)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $indentInstrument->instrument->instrument_id ?? null }}</td>
                                    <td class="text-center">{{ $indentInstrument->instrument->name ?? null }}</td>
                                    <td class="text-center">{{ $indentInstrument->instrument->instrumentType->name ?? null }}</td>
                                    <td class="text-center">{{ $indentInstrument->instrument->manufacture->name ?? null }}</td>
                                    <td class="text-center">{{ $indentInstrument->quantity ?? null }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $indentInstrument->id }})">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Remove</span>
                                        </button>
                                        <form id="delete-form-{{ $indentInstrument->id }}"
                                              action="{{ route('intentOfficer.indents.product.delete',['indentId'=>$indent->id,'productId'=>$indentInstrument->id]) }}"
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
                                <th class="text-center">Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Instrument</th>
                                <th class="text-center">Manufacturer</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($indent->parts as $key=>$indentPart)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $indentPart->part->name ?? null }}</td>
                                    <td class="text-center">{{ $indentPart->part->partType->name ?? null }}</td>
                                    <td class="text-center">{{ $indentPart->part->instrument->name  ?? null}}</td>
                                    <td class="text-center">{{ $indentPart->part->manufacture ? $indentPart->part->manufacture->name : '' }}</td>
                                    <td class="text-center">{{ $indentPart->quantity ?? null }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $indentPart->id }})">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Delete</span>
                                        </button>
                                        <form id="delete-form-{{ $indentPart->id }}"
                                              action="{{ route('intentOfficer.indents.product.delete',['indentId'=>$indent->id,'productId'=>$indentPart->id]) }}"
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
        $('#instrument').on('select2:select', function (e) {
            $('#type').val(null).trigger('change');
        });

        $(document).ready(function() {
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#product').select2({
                    dropdownParent: $('#exampleModal'),
                    placeholder: 'Select an option'
                });
            });
        });

        $('#type').on('select2:select', function (e) {
            const type = e.params.data.id;
            // Make a request for a user with a given ID
            let url;
            @if($indent->product_type === 'instrument')
                url = "/intent-officer/get-instruments/"  + instrumentId + "/" + type;
            @else
            let instrumentId = $('#instrument').select2('data')[0].id;
            url = "/intent-officer/get-parts/" + instrumentId + "/" + type;
            @endif
            axios.get(url)
                .then(function (response) {
                    // handle success
                    console.log(response.data);
                    let product = $('#product');
                    product.val(null).trigger('change');
                    product.empty();
                    response.data.forEach((item) => {
                        // create the option and append to Select2
                        let option = @if($indent->product_type === 'instrument') new Option(item.name + ' - ' + item.model, item.id, true, true)
                        @else new Option(item.name, item.id, true, true) @endif;
                        product.append(option).trigger('change');
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        });
    </script>
@endpush
