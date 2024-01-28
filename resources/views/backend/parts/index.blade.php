@extends('layouts.app')

@section('title','Parts')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Parts </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                @if (auth()->user())
                <li class=" mr-2">
                    <a href="{{ route('admin.parts.export') }}" class="customButton">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-arrow-down"></i>
                    </span>
                        Export
                    </a>
                </li>

                <li class="nav-item mr-2">
                    <button type="button" class="btn customButton" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="You can import 1000 rows at a time!">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-arrow-up"></i>
                    </span>
                        Import
                    </button>
                </li>
                @endif
                <li class="">
                    <a href="{{ route('admin.parts.create') }}" class="customButton">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Part
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

{{-- Modal --}}
@section('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload your import file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.parts.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- <label for="form-file">Upload a file</label> <br>
                    <input type="file" name="file" id="form-file" class="hidden" /> --}}

                    <x-forms.textbox label="Upload a file" type="file" name="file">
                    </x-forms.textbox>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn customButton">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{--End Modal --}}

@section('content')
    {{-- Filter start --}}
    <div class="row">
        <div class="col-md-12 ">
            <div class="bg-white mx-1 my-4 px-5 py-2 rounded">
               <form action="{{route('admin.parts.index')}}" method="get">
                    <div class=" d-flex justify-content-around align-items-center py-2 ">
                        <div class="col-md-3">
                            <select name="type" class="custom-select" id="filter">
                                <option  disabled selected>Type</option>
                                @foreach($partTypes as $key=>$partType)
                                    <option>{{ $partType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-2">
                            <select name="instrument" class="custom-select" id="filter">
                                <option  disabled selected>Instrument</option>
                                @foreach($instruments as $key=>$instrument)
                                    <option>{{ $instrument->name }}</option>
                                @endforeach
                            </select>
                        </div>  --}}
                        <div class="col-md-3">
                            <select name="manufacturer" class="custom-select" id="filter">
                                <option disabled selected>Manufacturer</option>
                                @foreach($manufactures as $key=>$manufacture)
                                    <option>{{ $manufacture->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
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
                                    <a href="{{route('admin.parts.index')}}" class="btn btn-warning btn-sm  py-2 ml-2"> Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>

               </form>
            </div>
        </div>
    </div>
    {{-- Filter end --}}
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatables" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">SL No 3.</th>
                            <th class="text-center">Item ID</th>
                            <th class="text-center">Part Name</th>
                            <th class="text-center">Instrument</th>
                            <th class="text-center">Specification</th>
                            <th class="text-center">Part Type</th>
                            <th class="text-center">Designation/Symbol No</th>
                            <th class="text-center">Part No</th>
                            <th class="text-center">Purchase Date</th>
                            <th class="text-center">Part Position</th>
                            <th class="text-center">Part Manufacturer</th>
                           <th class="text-center">Quantity</th>
                           {{-- <th class="text-center">Number in use</th> --}}
                           {{-- <th class="text-center">Present Stock</th> --}}
                           <th class="text-center">Comments</th>
                           <th class="text-center">Ledger Information</th>
                           <th class="text-center">Attachment</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parts as $key=>$part)

                            @if (!auth()->user()->isAdmin() && $part->quantity <= 0)
                                <tr style="opacity:0.5">
                            @else
                                <tr style="opacity:1">
                            @endif
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $part->part_id }}</td>
                                <td class="text-center">{{ $part->name }}</td>
                                <td class="text-center">{{ $part->instrument ? $part->instrument->name : '' }}</td>
                                <td class="text-center">{{ $part->specification }}</td>
                                <td class="text-center">{{ $part->partType->name }}</td>
                                <td class="text-center">{{ $part->designation }}</td>
                                <td class="text-center">{{ $part->parts_no }}</td>
                                <td class="text-center">{{ $part->purchase_date }}</td>
                                <td class="text-center">{{ $part->parts_pos }}</td>
                                <td class="text-center">{{ $part->manufacture ? $part->manufacture->name : '' }}</td>
                                <td class="text-center">{{ $part->quantity }}</td>
                                {{-- <td class="text-center">{{ $part->in_use }}</td> --}}
                                {{-- <td class="text-center">{{ $part->present_stock }}</td> --}}
                                <td class="text-center">{{ $part->comments }}</td>
                                <td class="text-center">{{ $part->ledger_information }}</td>
                                <td class="text-center"><a href="{{ Storage::url($part->parts_attached_file) }}">{{$part->parts_attached_file}}</a></td>

                                <td class="text-center">
                                    @if (auth()->user()->isAdmin() || $part->quantity <= 0)
                                        <a class="btn customButton btn-sm " style="opacity:1"
                                            href="{{ route('admin.parts.edit',$part->id) }}"><i
                                                class="mdi mdi-pencil"></i>
                                            <span>Edit</span>
                                        </a>
                                    @else
                                        {{-- <a class="btn btn-info btn-sm disabled-link" disabled
                                            href="{{ route('admin.parts.edit',$part->id) }}"><i
                                                class="mdi mdi-pencil"></i>
                                            <span>Edit</span>
                                        </a>  --}}
                                        <a href="/" class="btn customButton btn-sm " style="opacity:0.5;pointer-events: none;" onclick="return false;">
                                            <i class="mdi mdi-pencil"></i>
                                            <span>Edit</span>
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $part->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $part->id }}"
                                          action="{{ route('admin.parts.destroy',$part->id) }}" method="POST"
                                          style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="paginate" style="display: flex; justify-content: flex-end;">
                    {{ $parts->links() }}
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
