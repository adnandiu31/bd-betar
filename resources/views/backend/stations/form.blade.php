@extends('layouts.app')

@section('title','Users')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> {{ isset($station) ? 'Update' : 'Add' }} Station </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.stations.index') }}" class="btn-shadow btn btn-danger">
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
        <div class="col-sm-12 col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form method="POST"
                          action="{{ isset($station) ?  route('admin.stations.update',$station->id) : route('admin.stations.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($station)
                            @method('PUT')
                        @endisset

                        <x-forms.textbox label="Station Name"
                                         name="name"
                                         value="{{ $station->name ?? ''  }}"
                                         field-attributes="required autofocus">
                        </x-forms.textbox>

                        <x-forms.textbox label="Station Address"
                                         name="address"
                                         value="{{ $station->address ?? ''  }}"
                                         field-attributes="required">
                        </x-forms.textbox>
                        <button type="submit" class="btn customButton mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
