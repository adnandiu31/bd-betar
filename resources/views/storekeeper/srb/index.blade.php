@extends('layouts.app')

@section('title','Indents')

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
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> SRB</h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn customButton" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Select indent
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
                    <h5 class="modal-title" id="exampleModalLabel">Issue New SRB Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('storekeeper.srb.store') }}">
                    @csrf
                    <div class="modal-body">
                        <x-forms.select label="Select Indent"
                                        id="indent"
                                        name="indent"
                                        class="select js-example-basic-single">
                            @foreach($indents as $key=>$indent)
{{--                                <x-forms.select-item :value="$indent->id" :label="$indent->date.' '.$indent->indent_id" />--}}
                                <option value="{{$indent->id}}">{{$indent->date .' '.$indent->indent_id}}</option>
                            @endforeach
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
                                    @if($srb->adjust == true)
                                        <span class="badge badge-success">Adjusted</span>
                                    @else
                                        <span class="badge badge-danger">{{$srb->status == true?'Submited':'Drafted'}}</span>
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

                                    @if ($srb->adjust)
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('storekeeper.srb.export',$srb->id) }}"><i
                                                class="mdi mdi-download"></i>
                                            <span>Download</span>
                                        </a>
                                    @endif
                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('storekeeper.srb.show',$srb->id) }}"><i
                                            class="mdi mdi-eye"></i>
                                        <span>Show</span>
                                    </a>
                                    @if(!$srb->approved_by_si_at)
                                    <a class="btn customButton btn-sm"
                                       href="{{ route('storekeeper.srb.edit',$srb->id) }}"><i
                                            class="mdi mdi-pencil"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $srb->id }})">
                                        <i class="mdi mdi-delete"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $srb->id }}"
                                          action="{{ route('storekeeper.srb.destroy',$srb->id) }}" method="POST"
                                          style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
                                    @endif
                                    @if($srb->approved_by_si_at != null && $srb->approved_by_sh_at != null && $srb->approved_by_ce_at != null && $srb->approved_by_me_at != null && $srb->approved_by_dg_at != null && !$srb->adjust)
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('storekeeper.srb.adjust',$srb->id) }}"><i
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

        $(document).ready(function() {
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#indent').select2({
                    dropdownParent: $('#exampleModal'),
                    placeholder: 'Select an option'
                });
            });
        });
    </script>
@endpush
