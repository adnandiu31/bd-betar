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
              </span> Indents Request</h3>
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
                            <th class="text-center">Date</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Approval Status</th>
                            <th class="text-center">Final Approval</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menufactureList as $key=>$indent)
                            <tr>
                                <!-- <td class="text-center text-muted">{{ $key + 1 }}</td> -->
                                <td class="text-center text-muted">{{ $indent->id }}</td>
                                <td class="text-center">{{ $indent['manufacture']->name }}</td>
                                <td class="text-center">{{ $indent->date }}</td>
                                <td class="text-center">
                                    @if($indent->status == 1)
                                        <span class="badge badge-success">Submitted</span>
                                    @else
                                        <span class="badge badge-danger">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <p>
                                        @if($indent->status != true)
                                            <span class="badge badge-danger">Not Submitted yet</span>
                                        @else
                                            @if($indent->approved_by_se_at == null)
                                                <span
                                                    class="badge badge-danger"> Waiting for SE Approval </span>
                                            @elseif($indent->approved_by_se_at != null && $indent->approved_by_me_at == null)
                                                <span
                                                    class="badge badge-danger"> Waiting for Main-Engineer Approval </span>
                                            @elseif($indent->approved_by_me_at != null && $indent->approved_by_ce_at == null)
                                                <span class="badge badge-danger"> Waiting for CE Approval </span>
                                            @elseif($indent->approved_by_ce_at != null && $indent->approved_by_dg_at == null)
                                                <span class="badge badge-danger"> Waiting for DG Approval </span>
                                            @elseif($indent->approved_by_se_at != null && $indent->approved_by_me_at != null && $indent->approved_by_ce_at != null && $indent->approved_by_dg_at != null)
                                                <span class="badge badge-success">Approved By All</span>
                                            @endif
                                        @endif
                                    </p>
                                </td>

                                <td class="text-center">
                                    @if($indent->final_approval == null)
                                        <span class="badge badge-danger">Not Applied</span>
                                    @else
                                        <span class="badge badge-success">{{$indent->user->name}}</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($indent->approved_by_dg_at )
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('centralEngineer.indents.pdf',$indent->manufacture_id) }}"><i
                                                class="mdi mdi-download"></i>
                                            <span>Download</span>
                                        </a>
                                    @else
                                        <a class="btn btn-sencondary btn-sm border"
                                           href="#"><i
                                                class="mdi mdi-download"></i>
                                            <span>Download</span>
                                        </a>
                                    @endisset
                        
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('centralEngineer.indents.partList',$indent->id) }}"><i
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
