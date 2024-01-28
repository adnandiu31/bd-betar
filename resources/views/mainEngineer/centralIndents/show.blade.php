@extends('layouts.app')

@section('title','Indent')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
                Indent Request Details
            </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item mr-2">
                    <form method="post" action="{{ route('mainEngineer.indents.statusChange',$indent->id) }}">
                        @csrf
                        <button type="submit" class="btn {{ $indent->status == true ? 'btn-success' : 'btn-danger' }}">
                            Mark as {{ $indent->status == true ? 'Draft' : 'Submit' }}
                        </button>
                    </form>
                </li>


                @if ($indent->approved_by_se_at ==!null)
                <li class="nav-item mr-2">
                    <form method="post" action="{{ route('mainEngineer.indents.finalApproved',$indent->id) }}">
                        @csrf
                        <button type="submit" class="btn {{ $indent->final_approval ? 'btn-success': 'btn-danger' }}">
                            Mark as {{ $indent->approved_by_ace_at  ? 'Final Approved' : 'Cancel Final Aprroved' }}
                        </button>
                    </form>
                </li>
                @endif

                @if ($indent->approved_by_se_at ==!null)
                <li class="nav-item mr-2">
                    <form method="post" action="{{ route('mainEngineer.indents.approved',$indent->id) }}">
                        @csrf
                        <button type="submit" class="btn {{ $indent->approved_by_me_at ? 'btn-success': 'btn-danger' }}">
                            Mark as {{ $indent->approved_by_me_at  ? 'Pending' : 'Approved' }}
                        </button>
                    </form>
                </li>
                @endif
        
                <li class="nav-item">
                    <a href="{{ route('mainEngineer.indents.manufactureList') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="mdi mdi-arrow-left"></i>
                    </span>
                        Back to list
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Indent Timeline</h4>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"  id="profile-tab" data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile" aria-selected="false">Products</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home-1" role="tab" aria-controls="home" aria-selected="true">Timeline</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="home-1" role="tabpanel" aria-labelledby="home-tab">
                        <div class="timeline">
                                <div class="timeline-wrapper timeline-wrapper-primary">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h6 class="timeline-title">Indent Request Started</h6>
                                        </div>
                                        <div class="timeline-body">
                                            <p>
                                                <strong>Date:</strong> {{ $indent->date }} <br>
                                                <strong>Status:</strong>
                                                @if($indent->status == true)
                                                    <span class="badge badge-success">Submitted</span>
                                                @else
                                                    <span class="badge badge-danger">Draft</span>
                                                @endif
                                            </p>
                                            <p>
                                                <strong>Note:</strong>
                                                {{ $indent->note }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-wrapper timeline-inverted timeline-wrapper-{{ isset($indent->approved_by_se_at) ? 'success' : 'danger' }}">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        @isset($indent->approved_by_se_at)
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">SE approved at {{ $indent->approved_by_se_at }}</h6>
                                            </div>
                                        @else
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Waiting for SE approval</h6>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                                <div class="timeline-wrapper timeline-wrapper-{{ isset($indent->approved_by_me_at) ? 'success' : 'danger' }}">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        @isset($indent->approved_by_me_at)
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Main Engineer approved at {{ $indent->approved_by_me_at }}</h6>
                                            </div>
                                        @else
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Waiting for Main Engineer approval</h6>
                                            </div>
                                        @endisset
                                    </div>
                                </div>

                                <div class="timeline-wrapper timeline-inverted timeline-wrapper-{{ isset($indent->approved_by_ce_at) ? 'success' : 'danger' }}">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        @isset($indent->approved_by_ce_at)
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Central Engineer approved at {{ $indent->approved_by_ce_at }}</h6>
                                            </div>
                                        @else
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Waiting for Central Engineer approval</h6>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                               
                                <div class="timeline-wrapper  timeline-wrapper-{{ isset($indent->approved_by_dg_at) ? 'success' : 'danger' }}">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        @isset($indent->approved_by_dg_at)
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Director General approved at {{ $indent->approved_by_dg_at }}</h6>
                                            </div>
                                        @else
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Waiting for Director General approval</h6>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive">
                                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Parts Id</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Parts No</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Requisition</th>
                                        <th class="text-center">Unit Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($partLists as $key=>$indent)
                                                <tr>
                                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                                    <td class="text-center">{{ $indent->part_id }}</td>
                                                    <td class="text-center">{{ $indent->name }}</td>
                                                    <td class="text-center">{{ $indent->parts_no }}</td>
                                                    <td class="text-center">{{ $indent->type }}</td>
                                                    <td class="text-center">{{ $indent->quantity }}</td>
                                                    <td class="text-center">{{ $indent->remaining }}</td>
                                                    <td class="text-center">{{ $indent->unit_price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
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
