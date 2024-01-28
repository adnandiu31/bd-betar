@extends('layouts.app')

@section('title','Manual')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Indent </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row role-title-page app-page-title mb-3">
        <div class="col-md-12 page-title-wrapper">
            <div class="page-title-heading mt-1">
                <h4>Indent List</h4>
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
                            <th class="text-center">Product Type</th>
                            <th class="text-center">Product Model</th>
                            <th class="text-center">Cons Years</th>
                            <th class="text-center">Req of last 2 years</th>
                            <th class="text-center">Quantity inuse</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">ABC 01</td>
                                <td class="text-center">Beta</td>
                                <td class="text-center">Rader</td>
                                <td class="text-center">Name</td>
                                <td class="text-center">Q Name</td>
                            </tr>

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
        $(document).ready(function() {
            // Datatable
            $("#datatable").DataTable();
        });
    </script>
@endpush
