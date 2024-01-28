@extends('layouts.app')

@section('title','Instrument Types')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Instrument Types </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="customButton">
                    <a href="{{ route('admin.instrument-types.create') }}" class="">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Instrument Type
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
                            <th class="text-center">ID</th>
                            <th class="text-center">Instrument Type</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($instrumentTypes as $key=>$instrumentType)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $instrumentType->name }}</td>
                                <td class="text-center">
                                    <a class="btn customButton btn-sm"
                                       href="{{ route('admin.instrument-types.edit',$instrumentType->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $instrumentType->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $instrumentType->id }}"
                                          action="{{ route('admin.instrument-types.destroy',$instrumentType->id) }}" method="POST"
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
