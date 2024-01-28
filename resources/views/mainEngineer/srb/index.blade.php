@extends('layouts.app')

@section('title','SRB')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> SRB Request</h3>
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
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Station</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($srbs as $key=>$srb)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center text-muted">{{ $srb->indent->station->name ?? null}}</td>
                                <td class="text-center">{{ ucfirst($srb->indent->product_type) }}</td>
                                <td class="text-center">{{ $srb->created_at}}</td>
                                <td class="text-center">
                                    @isset($srb->approved_by_me_at)
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-danger">Pending</span>
                                    @endisset
                                </td>
                                <td class="text-center">
                                    @if ($srb->adjust)
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('storekeeper.srb.export',$srb->id) }}"><i
                                                class="mdi mdi-download"></i>
                                            <span>Download</span>
                                        </a>
                                    @endif
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('mainEngineer.srb.show',$srb->id) }}"><i
                                            class="mdi mdi-eye"></i>
                                        <span>Show</span>
                                    </a>
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