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
        {{-- <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.stock.parts.create') }}" class="btn-shadow btn btn-info">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Part
                    </a>
                </li>
            </ul>
        </div> --}}
    </div>
@endsection

@section('content')
    {{-- Filter start --}}
    <div class="row">
        <div class="col-md-12 ">
            <div class="bg-white mx-1 my-4 px-5 py-2 rounded">
               <form action="{{route('admin.stock.parts.index')}}" method="get">
                    <div class=" d-flex justify-content-around align-items-center py-2 ">

                        <div class="col-md-2">
                            <select name="station" class="custom-select" id="filter">
                                <option  disabled selected>Station</option>
                                @foreach($stations as $key=>$station)
                                    <option>{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
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
                        </div> --}}

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
                                    <a href="{{route('admin.stock.parts.index')}}" class="btn btn-warning btn-sm  py-2 ml-2"> Reset</a>
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
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            {{-- <th class="text-center">Station</th> --}}
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            {{-- <th class="text-center">Instruments</th> --}}
                            <th class="text-center">Type</th>
                            <th class="text-center">Manufacturer</th>
                            <th class="text-center">Quantity</th>
                            {{-- <th class="text-center">Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stockParts as $key=>$stockPart)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $stockPart->part_id }}</td>
                                <td class="text-center">{{ $stockPart->name }}</td>
                                <td class="text-center">{{ $stockPart->partType->name }}</td>
                                <td class="text-center">{{ $stockPart->manufacture? $stockPart->manufacture->name : '' }}</td>
                                <td class="text-center">{{ $stockPart->quantity }}</td>
                                {{-- <td class="text-center">
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('admin.stock.parts.edit',$stockPart->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $stockPart->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $stockPart->id }}"
                                          action="{{ route('admin.stock.parts.destroy',$stockPart->id) }}" method="POST"
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
