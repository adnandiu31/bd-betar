@extends('layouts.app')

@section('title','Products')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Product </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row role-title-page app-page-title mb-3">
        <div class="col-md-12 page-title-wrapper">
            <div class="page-title-heading mt-1">
                <h4>All Products</h4>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('createproduct') }}" class="btn-shadow btn btn-info">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                    Add Product
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
                            <th class="text-center">Manufacture</th>
                            <th class="text-center">Model</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Sr. No</th>
                            <th class="text-center">Symbol No</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">ABC 01</td>
                                <td class="text-center">Beta</td>
                                <td class="text-center">Rader</td>
                                <td class="text-center">SR@3</td>
                                <td class="text-center">sym@1</td>
                                <td class="text-center">
                                <a class="btn btn-primary btn-sm" href="#"><i
                                    class="mdi mdi-eye"></i>
                                    <span>Show</span>
                                </a>
                                <a class="btn btn-info btn-sm" href="#"><i
                                    class="mdi mdi-pencil"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i>
                                    <span>Delete</span>
                                </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">ABC 01</td>
                                <td class="text-center">Beta</td>
                                <td class="text-center">Rader</td>
                                <td class="text-center">SR@3</td>
                                <td class="text-center">sym@1</td>
                                <td class="text-center">
                                <a class="btn btn-primary btn-sm" href="#"><i
                                    class="mdi mdi-eye"></i>
                                    <span>Show</span>
                                </a>
                                <a class="btn btn-info btn-sm" href="#"><i
                                    class="mdi mdi-pencil"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i>
                                    <span>Delete</span>
                                </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">ABC 01</td>
                                <td class="text-center">Beta</td>
                                <td class="text-center">Rader</td>
                                <td class="text-center">SR@3</td>
                                <td class="text-center">sym@1</td>
                                <td class="text-center">
                                <a class="btn btn-primary btn-sm" href="#"><i
                                    class="mdi mdi-eye"></i>
                                    <span>Show</span>
                                </a>
                                <a class="btn btn-info btn-sm" href="#"><i
                                    class="mdi mdi-pencil"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i>
                                    <span>Delete</span>
                                </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">ABC 01</td>
                                <td class="text-center">Beta</td>
                                <td class="text-center">Rader</td>
                                <td class="text-center">SR@3</td>
                                <td class="text-center">sym@1</td>
                                <td class="text-center">
                                <a class="btn btn-primary btn-sm" href="#"><i
                                    class="mdi mdi-eye"></i>
                                    <span>Show</span>
                                </a>
                                <a class="btn btn-info btn-sm" href="#"><i
                                    class="mdi mdi-pencil"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i>
                                    <span>Delete</span>
                                </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center text-muted">#1</td>
                                <td class="text-center">ABC 01</td>
                                <td class="text-center">Beta</td>
                                <td class="text-center">Rader</td>
                                <td class="text-center">SR@3</td>
                                <td class="text-center">sym@1</td>
                                <td class="text-center">
                                <a class="btn btn-primary btn-sm" href="#"><i
                                    class="mdi mdi-eye"></i>
                                    <span>Show</span>
                                </a>
                                <a class="btn btn-info btn-sm" href="#"><i
                                    class="mdi mdi-pencil"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i>
                                    <span>Delete</span>
                                </button>
                                </td>
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
