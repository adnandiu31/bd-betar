@extends('layouts.app')

@section('title','Instruments')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Instruments </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                @if (auth()->user()->isAdmin())
                <li class=" mr-2">
                    <a href="{{ route('admin.instruments.export') }}" class="customButton">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Export
                    </a>
                </li>
                <li class="nav-item mr-2">
                    <button type="button" class="btn customButton" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Import
                    </button>
                </li>
                @endif
                <li class="">
                    <a href="{{ route('admin.instruments.create') }}" class="customButton">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Instrument
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
            <form method="POST" action="{{ route('admin.instruments.import') }}" enctype="multipart/form-data">
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
               <form action="{{route('admin.instruments.index')}}" method="get">
                    <div class=" d-flex justify-content-around align-items-center py-2 ">
                        <div class="col-md-3">
                            <select name="type" class="custom-select" id="filter">
                                <option  disabled selected>Type</option>
                                @foreach($instrumentsTypes as $key=>$instrumentType)
                                    <option>{{ $instrumentType->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                                    <a href="{{route('admin.instruments.index')}}" class="btn btn-warning btn-sm  py-2 ml-2"> Reset</a>
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
                            <th class="text-center">#</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Instrument Name</th>
                            {{--<th class="text-center">Station</th>--}}
                            <th class="text-center">Description/Specification</th>
                            <th class="text-center">Instrument Type</th>
                            <th class="text-center">Instrument Model</th>
                            <th class="text-center">Serial No</th>
                            <th class="text-center">Ins Manufacturer</th>
                            <th class="text-center">Date instalation</th>
                            <th class="text-center">Attached File</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($instruments as $key=>$instrument)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $instrument->instrument_id }}</td>
                                <td class="text-center">{{ $instrument->name }}</td>
                                <td class="text-center">{{ $instrument->description }}</td>
                                <td class="text-center">{{ $instrument->instrumentType->name }}</td>
                                <td class="text-center">{{ $instrument->model }}</td>
                                <td class="text-center">{{ $instrument->serial_no }}</td>
                                <td class="text-center">{{ $instrument->manufacture ? $instrument->manufacture->name : '' }}</td>
                                <td class="text-center">{{ $instrument->installation_date}}</td>
                                <td class="text-center"><a href="{{ Storage::url($instrument->attachment_path) }}">{{$instrument->attachment_path}}</a></td>
                                <td class="text-center">
                                    <a class="btn customButton btn-sm"
                                       href="{{ route('admin.instruments.edit',$instrument->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $instrument->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $instrument->id }}"
                                          action="{{ route('admin.instruments.destroy',$instrument->id) }}" method="POST"
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
                    {{ $instruments->links() }}
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

            //
            $('#filter').on('change', function (e) {
				getMoreUsers();
            });
        });

        function getMoreUsers() {

            var selectedType = $("#filter option:selected").val();
            console.log("Click ajax",selectedType);

            // $.ajax({
            //     type: "GET",
            //     data: {
            //         'filter': selectedType,
            //     },
            //     url: "{{ route('admin.instruments.store') }}",
            //     success:function(data) {
            //         $('#datas').html(data);
            //     }
            // });
        }

    </script>
@endpush
