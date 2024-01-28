@extends('layouts.app')

@section('title','SIB')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
                SIB Request Details
            </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                @if(!isset($sib->approved_by_sh_at))
                    <li class="nav-item mr-2">
                        <form method="post" action="{{ route('stationIncharge.sib.changeStatus',$sib->id) }}">
                            @csrf
                            <button type="submit" class="btn {{ isset($sib->approved_by_si_at) ? 'btn-danger' : 'btn-success' }}">
                                Mark as  {{ isset($sib->approved_by_si_at) ? 'Pending' : 'Approved' }}
                            </button>
                        </form>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('stationIncharge.sib.index') }}" class="btn-shadow btn btn-danger">
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
                    <h4 class="card-title">SIB Timeline</h4>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile" aria-selected="false">Products</a>
                        </li>
                        <li class="nav-item">
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
                                            <h6 class="timeline-title">SIB Request Started</h6>
                                        </div>
                                        <div class="timeline-body">
                                            <p>
                                                <strong>Date:</strong> {{ $sib->created_at }} <br>
                                                <strong>Status:</strong>
                                                @if($sib->status == true)
                                                    <span class="badge badge-success">Submitted</span>
                                                @else
                                                    <span class="badge badge-danger">Draft</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-wrapper timeline-inverted timeline-wrapper-{{ isset($sib->approved_by_si_at) ? 'success' : 'danger' }}">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        @isset($sibw->approved_by_si_at)
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Station Incharge approved at {{ $sib->approved_by_si_at }}</h6>
                                            </div>
                                        @else
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Waiting for Station Incharge approval</h6>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                                <div class="timeline-wrapper timeline-wrapper-{{ isset($sib->approved_by_sh_at) ? 'success' : 'danger' }}">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-panel">
                                        @isset($sib->approved_by_sh_at)
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Station Head approved at {{ $sib->approved_by_sh_at }}</h6>
                                            </div>
                                        @else
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">Waiting for Station Head approval</h6>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive">
                                @if($sib->product_type === 'instrument')
                                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Manufacturer</th>
                                            <th class="text-center">Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sib->instruments as $key=>$sibInstrument)
                                            <tr>
                                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $sibInstrument->instrument_id }}</td>
                                                <td class="text-center">{{ $sibInstrument->instrument->name }}</td>
                                                <td class="text-center">{{ $sibInstrument->instrument->instrumentType->name ?? null }}</td>
                                                <td class="text-center">{{ $sibInstrument->instrument->manufacture->name ?? null }}</td>
                                                <td class="text-center">{{ $sibInstrument->quantity }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Manufacturer</th>
                                            <th class="text-center">Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sib->parts as $key=>$sibPart)
                                            <tr>
                                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                                {{-- <td class="text-center">{{ $sibPart->part->part->name }}</td> --}}
                                                <td class="text-center">{{ $sibPart->part->name }}</td>
                                                <td class="text-center">{{ $sibPart->part->partType->name ?? null }}</td>
                                                <td class="text-center">{{ $sibPart->part->manufacture->name ?? null }}</td>
                                                <td class="text-center">{{ $sibPart->quantity }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
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
