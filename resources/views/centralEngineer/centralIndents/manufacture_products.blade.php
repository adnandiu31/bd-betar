@extends('layouts.app')

@section('title','Indents')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span>Manufacture's Parts </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-2 mt-3 align-items-center">
                <div>
                    <h3>Menufacturer Name: {{ $manufacture['name'] }}</h3>     
                </div>
                <div>
                    <a class="btn btn-info btn-sm"
                        href="{{ route('centralEngineer.indents.pdf',$manufacture['id']) }}">
                        <i class="mdi mdi-download"></i>
                        <span>Download</span>
                    </a>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Parts Id</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Parts No</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Requisition</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $key=>$indent)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $indent->part_id }}</td>
                                    <td class="text-center">{{ $indent->name }}</td>
                                    <td class="text-center">{{ $indent->parts_no }}</td>
                                    <td class="text-center">{{ $indent->type }}</td>
                                    <td class="text-center">{{ $indent->quantity }}</td>
                                    <td class="text-center">
                                        <form id="updatePart-{{$indent->id}}" action="{{route('centralEngineer.indents.requisitionUpdate',['part_id'=>$indent->part_id,'central_indent_id'=>$indent->central_indent_id])}}" method="POST">
                                            @csrf
                                            <input name="requisition" type="number" class="form-control" value="{{$indent->remaining}}">
                                        </form>
                                    </td>
                                    <td>
                                        <button onclick="document.getElementById(`updatePart-{{$indent->id}}`).submit()" type="button" class="btn btn-danger btn-sm"
                                        >
                                            <span>{{"Update"}}</span>
                                        </button>
                                    </td>
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

            function navigateToPage() {
                // Get the selected option value
                var selectedValue = document.getElementById("myDropdown").value;

                // Check if the selected value is not the placeholder
                if (selectedValue !== "#") {
                    // Redirect to the selected page
                    window.location.href = selectedValue;
                }
            }
        });
    </script>
@endpush
