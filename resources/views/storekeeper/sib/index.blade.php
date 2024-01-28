@extends('layouts.app')

@section('title','sibs')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> SIB</h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn customButton" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        New SIB
                    </button>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New sib Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('storekeeper.sib.store') }}">
                    @csrf
                    <div class="modal-body">
                        <x-forms.select label="Product Type"
                                        name="type"
                                        class="">
                            <x-forms.select-item value="instrument" label="Instrument" selected />
                            <x-forms.select-item value="part" label="Part" />
                        </x-forms.select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn customButton">Submit</button>
                    </div>
                </form>
            </div>
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
                            <th class="text-center">Status</th>
                            <th class="text-center">Approval Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sibs as $key=>$sib)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ ucfirst($sib->product_type) }}</td>
                                <td class="text-center">
                                    @if($sib->adjust == true)
                                        <span class="badge badge-success">Adjusted</span>
                                    @else
                                        <span class="badge badge-danger">{{$sib->status == true?'Submited':'Drafted'}}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <p>
                                        @if($sib->status != true)
                                            <span class="badge badge-danger">Not Submitted yet</span>
                                        @else
                                            @if($sib->approved_by_si_at == null)
                                                <span class="badge badge-danger"> Waiting for Station Incharge Approval </span>
                                            @elseif($sib->approved_by_si_at != null && $sib->approved_by_sh_at == null)
                                                <span class="badge badge-danger"> Waiting for Station Head Approval </span>
                                            @elseif($sib->approved_by_si_at != null && $sib->approved_by_sh_at != null)
                                                <span class="badge badge-success">Approved By All</span>
                                            @endif
                                        @endif
                                    </p>
                                </td>
                                <td class="text-center">
                                    @if ($sib->adjust)
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('storekeeper.sib.export',$sib->id) }}"><i
                                                class="mdi mdi-download"></i>
                                            <span>Download</span>
                                        </a>
                                    @endif
                                    <a class="btn customButton btn-sm"
                                       href="{{ route('storekeeper.sib.show',$sib->id) }}"><i
                                            class="mdi mdi-eye"></i>
                                        <span>Show</span>
                                    </a>
                                    @if(!$sib->approved_by_si_at)
                                    <a class="btn customButton btn-sm"
                                       href="{{ route('storekeeper.sib.edit',$sib->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $sib->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $sib->id }}"
                                          action="{{ route('storekeeper.sib.destroy',$sib->id) }}" method="POST"
                                          style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
                                    @endif
                                    @if($sib->approved_by_si_at != null && $sib->approved_by_sh_at != null && !$sib->adjust)
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('storekeeper.sib.adjust',$sib->id) }}"><i
                                                class="mdi mdi-pencil"></i>
                                            <span>Adjust stock</span>
                                        </a>
                                    @endif
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
