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
        <div class="col-md-12 ">
            <div class="bg-white mx-1 my-4 px-5 py-2 rounded">
               <form action="{{route('mainEngineer.indents.index')}}" method="get">
                    <div class=" d-flex justify-content-around align-items-center py-2 ">
                        <div class="col-md-2">
                            <select name="station" class="custom-select" id="filter">
                                <option  disabled selected>Station</option>
                                @foreach($stations as $key=>$station)
                                    <option>{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-md-2">
                            <select name="manufacturer" class="custom-select" id="filter">
                                <option disabled selected>Manufacturer</option>
                                @foreach($manufactures as $key=>$manufacture)
                                    <option>{{ $manufacture->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="navbar-form" role="search">
                                <div class="input-group add-on">
                                    <input class="form-control" placeholder="Search" name="search" id="srch-term" type="text">

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex">
                                <div class=" ">
                                    <button type="submit" class="btn btn-info btn-sm py-2"> Filter</button>
                                </div>
                                <div>
                                    <a href="{{route('mainEngineer.indents.index')}}" class="btn btn-warning btn-sm  py-2 ml-2"> Reset</a>
                                </div>
                                <div>
                                    <a href="{{ route('mainEngineer.allApproved.forCentral') }}" class="btn btn-success btn-sm py-2 ml-2"> Approved all for Central</a>
                                </div>
                                <div>
                                    <a href="{{route('mainEngineer.allReject.forCentral')}}" class="btn btn-danger btn-sm  py-2 ml-2"> Reject For central</a>
                                </div>
                            </div>
                        </div>
                    </div>

               </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Station Name</th>
                            <th class="text-center">Manufacture name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Note</th>
                            <th class="text-center">For Central Indent Status</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($indents as $key=>$indent)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $indent->station->name }}</td>
                                <td class="text-center">{{ $indent->manufacture->name }}</td>
                                <td class="text-center">{{ ucfirst($indent->product_type) }}</td>
                                <td class="text-center">{{ $indent->name }}</td>
                                <td class="text-center">{{ $indent->date }}</td>
                                <td class="text-center">{{ $indent->note }}</td>
                                <td class="text-center">
                                    <p>
                                        @if($indent->approved_for_cen_ind == null)
                                            <span class="badge badge-danger"> Waiting for Main Engineer Approval</span>

                                        @else
                                            <span class="badge badge-success"> Approved </span>
                                        @endif
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p>
                                        @if($indent->status != true)
                                            <span class="badge badge-danger">Not Submitted yet</span>
                                        @else
                                            @if($indent->approved_by_si_at == null)
                                                <span
                                                    class="badge badge-danger"> Waiting for Station Incharge Approval </span>
                                            @elseif($indent->approved_by_si_at != null && $indent->approved_by_sh_at == null)
                                                <span
                                                    class="badge badge-danger"> Waiting for Station Head Approval </span>
                                            @elseif($indent->approved_by_si_at != null && $indent->approved_by_sh_at != null)
                                                <span class="badge badge-success">Approved By All</span>
                                            @endif
                                        @endif
                                    </p>
                                </td>
                                <td class="text-center">
                                    @if ($indent->isApproved())
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('mainEngineer.indents.export',$indent->id) }}"><i
                                                class="mdi mdi-download"></i>
                                            <span>Download</span>
                                        </a>
                                    @endif
                                    <a class="btn btn-info btn-sm"
                                       href="{{ route('mainEngineer.indents.show',$indent->id) }}"><i
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
