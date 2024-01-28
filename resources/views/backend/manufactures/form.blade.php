@extends('layouts.app')

@section('title','Users')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> {{ isset($manufacture) ? "Update" :"Add" }} Manufacture </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.manufactures.index') }}" class="btn-shadow btn btn-danger">
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
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form method="POST"
                          action="{{ isset($manufacture) ?  route('admin.manufactures.update',$manufacture->id) : route('admin.manufactures.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($manufacture)
                            @method('PUT')
                        @endisset
                        <x-forms.textbox label="Manufacture Name"
                                         name="name"
                                         value="{{ $manufacture->name ?? ''  }}"
                                         field-attributes="required autofocus">
                        </x-forms.textbox>

                       <div class="row">
                        <div class="col-md-6">
                            <x-forms.textbox label="Country"
                            name="country"
                            value="{{ $manufacture->country ?? ''  }}" >
                            </x-forms.textbox>
                        </div>

                        <div class="col-md-6">
                            <x-forms.textbox label="Address"
                                            name="address"
                                            value="{{ $manufacture->address ?? ''  }}">
                            </x-forms.textbox>
                        </div>
                       </div>

                        <button type="submit" class="btn customButton mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
