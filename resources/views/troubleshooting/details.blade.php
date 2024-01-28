@extends('layouts.app')

@section('title','Troubleshoot')

@push('css')
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-help"></i>
              </span> Troubleshoot </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('troubleshootings.index') }}" class="btn-shadow btn btn-danger">
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
        <div class="col-sm-12 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Repair id #{{ $troubleshoot->repair_id }}</p>
                    <div class="card card-inverse-secondary mb-3">
                      <div class="card-body">
                      <p class="mb-4 text-dark"><span class="font-weight-bold">Date</span> :  {{ $troubleshoot->date }}  </p>
                      <p class="mb-4 text-dark"><span class="font-weight-bold">Product name</span> : {{ $troubleshoot->product_name }}  </p>
                      </div>
                    </div>
                    <div class="card card-inverse-danger mb-3">
                      <div class="card-body">
                        <p class="mb-5 text-dark"><span class="font-weight-bold">Fault</span> :  {{ $troubleshoot->fault }}  </p>
                        <p class="mb-5 text-dark"><span class="font-weight-bold">Fault location</span> :  {{ $troubleshoot->fault_location }}  </p>
                        <p class="mb-4 text-dark"><span class="font-weight-bold">Symptoms</span> :  {{ $troubleshoot->symptom }}  </p>
                      </div>
                    </div>
                    <div class="card card-inverse-success mb-3">
                        <div class="card-body">
                          <p class="mb-5 text-dark"><span class="font-weight-bold">Solution</span> :  {{ $troubleshoot->solution }}  </p>
                        </div>
                    </div>
                    <div class="card card-inverse-info ">
                        <div class="card-body">
                          <p class="mb-4 text-dark"><span class="font-weight-bold">Station</span> :  {{ $troubleshoot->station_name }}  </p>
                          <p class="mb-4 text-dark"><span class="font-weight-bold">Solved by </span> :  {{ $troubleshoot->author }}  </p>
                          <p class="mb-4 text-dark"><span class="font-weight-bold">Designation</span> :  {{ $troubleshoot->designation }}  </p>
                          <p class="mb-4 text-dark"><span class="font-weight-bold">Email</span> :  {{ $troubleshoot->email }}  </p>
                          <p class="mb-4 text-dark"><span class="font-weight-bold">Phone Number</span> :  {{ $troubleshoot->mobile_number }}  </p>
                        </div>
                      </div>
                  </div>
            </div>
        </div>
    </div>
@endsection


@push('js')

@endpush