@extends('layouts.app')

@section('title','Instrument Types')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Instrument Types </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.instrument-types.index') }}" class="btn-shadow btn btn-danger">
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
                          action="{{ isset($instrumentType) ?  route('admin.instrument-types.update',$instrumentType->id) : route('admin.instrument-types.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($instrumentType)
                            @method('PUT')
                        @endisset

                        <x-forms.textbox label="Type Name"
                                         name="name"
                                         value="{{ $instrumentType->name ?? ''  }}"
                                         field-attributes="required autofocus">
                        </x-forms.textbox>
                        <button type="submit" class="btn customButton mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
