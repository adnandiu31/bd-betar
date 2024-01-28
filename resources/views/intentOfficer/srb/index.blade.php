@extends('layouts.app')

@section('title','Srbs')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> SRB</h3>
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
                            <th class="text-center">Type</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Approval Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($srbs as $key=>$srb)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ ucfirst($srb->indent->product_type) }}</td>
                                <td class="text-center">{{ $srb->created_at }}</td>
                                <td class="text-center">
                                    @if($srb->status == true)
                                        <span class="badge badge-success">Submitted</span>
                                    @else
                                        <span class="badge badge-danger">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <p>
                                        @if($srb->status != true)
                                            <span class="badge badge-danger">Not Submitted yet</span>
                                        @else
                                            @if($srb->approved_by_si_at == null)
                                                <span class="badge badge-danger"> Waiting for Station Incharge Approval </span>
                                            @elseif($srb->approved_by_si_at != null && $srb->approved_by_sh_at == null)
                                                <span class="badge badge-danger"> Waiting for Station Head Approval </span>
                                            @elseif($srb->approved_by_sh_at != null && $srb->approved_by_ce_at == null)
                                                <span class="badge badge-danger"> Waiting for CE Approval </span>
                                            @elseif($srb->approved_by_ce_at != null && $srb->approved_by_me_at == null)
                                                <span class="badge badge-danger"> Waiting for Me Approval </span>
                                            @elseif($srb->approved_by_me_at != null && $srb->approved_by_dg_at == null)
                                                <span class="badge badge-danger"> Waiting for DG Approval </span>
                                            @elseif($srb->approved_by_si_at != null && $srb->approved_by_sh_at != null && $srb->approved_by_ce_at != null && $srb->approved_by_me_at != null && $srb->approved_by_dg_at != null)
                                                <span class="badge badge-success">Approved By All</span>
                                            @endif
                                        @endif
                                    </p>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('storekeeper.srb.show',$srb->id) }}"><i
                                            class="mdi mdi-eye"></i>
                                        <span>Show</span>
                                    </a>
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('intentOfficer.srb.edit',$srb->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Products</span>
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
