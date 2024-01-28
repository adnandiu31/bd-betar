@extends('layouts.app')

@section('title','Ledgers')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Ledger </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row role-title-page app-page-title mb-3">
        <div class="col-md-12 page-title-wrapper">
            <div class="page-title-heading mt-1">
                <h4>All Ledgers</h4>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.ledgers.create') }}" class="btn-shadow btn btn-info">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                    Add Ledger
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Station Name</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ledgers as $key=>$ledger)
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">{{ $ledger->station->name }}</td>
                                <td class="text-center">{{ $ledger->address }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('admin.ledgers.edit',$ledger->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $ledger->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $ledger->id }}"
                                          action="{{ route('admin.ledgers.destroy',$ledger->id) }}" method="POST"
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
