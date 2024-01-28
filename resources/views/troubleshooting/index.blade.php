@extends('layouts.app')

@section('title','Troubleshooting')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Troubleshooting </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="customButton">
                    <a href="{{ route('troubleshootings.create') }}" class="">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Troubleshooting
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Repair id</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Fault Location</th>
                            <th class="text-center">Repair by</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($troubleshootings as $key=>$troubleshoot)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">#{{ $troubleshoot->repair_id }}</td>
                                <td class="text-center">{{ $troubleshoot->product_name }}</td>
                                <td class="text-center">{{ $troubleshoot->fault_location }}</td>
                                <td class="text-center">{{ $troubleshoot->author }}</td>
                                <td class="text-center">{{ $troubleshoot->date }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm"
                                       href="{{ route('troubleshootings.show',$troubleshoot->id) }}"><i
                                            class="mdi mdi-eye"></i>
                                        <span>Details</span>
                                    </a>
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('troubleshootings.edit',$troubleshoot->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $troubleshoot->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $troubleshoot->id }}"
                                          action="{{ route('troubleshootings.destroy',$troubleshoot->id) }}" method="POST"
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
