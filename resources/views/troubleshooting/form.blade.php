@extends('layouts.app')

@section('title','Troubleshooting')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-account-circle"></i>
              </span> {{ __((isset($troubleshoot) ? '' : '') . ' Troubleshooting') }} </h3>
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
        <div class="col-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <!-- form start -->
            <form role="form" id="userFrom" method="POST"
                  action="{{ isset($troubleshoot) ? route('troubleshootings.update',$troubleshoot->id) : route('troubleshootings.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if (isset($troubleshoot))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Troubleshooting info</h5>

                                <x-forms.textbox label="Product name"
                                                 name="product_name"
                                                 value="{{ $troubleshoot->product_name ?? ''  }}"
                                                 field-attributes="required autofocus">
                                </x-forms.textbox>

                                <div class="row">
                                    <div class="col-md-9">
                                        <x-forms.textbox type="text"
                                                 label="Fault"
                                                 name="fault"
                                                 value="{{ $troubleshoot->fault ?? ''  }}" />
                                    </div>

                                    <div class="col-md-3">
                                        <x-forms.textbox type="date"
                                                    label="date"
                                                    name="date"
                                                    value="{{ $troubleshoot->date ?? ''  }}" />
                                    </div>
                                </div>

                                

                                <div class="row">
                                    <div class="col-md-6">
                                        <x-forms.textbox type="text"
                                                 label="Fault location"
                                                 name="fault_location"
                                                 value="{{ $troubleshoot->fault_location ?? ''  }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-forms.textbox type="text"
                                                 label="Symptom"
                                                 name="symptom"
                                                 value="{{ $troubleshoot->symptom ?? ''  }}" />
                                    </div>
                                </div>
                                <x-forms.textbox type="text"
                                                 label="Solution"
                                                 name="solution"
                                                 value="{{ $troubleshoot->solution ?? ''  }}" />        

                               <!-- <x-forms.dropify label="fault image (Only Image are allowed)"
                                                 name="fault_image"
                                                 value="{{ isset($user) ? $troubleshoot->getFirstMediaUrl('fault_image','thumb') : ''  }}"/> -->
                          
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Fault Solved By</h5>
                                <x-forms.textbox type="text"
                                                label="Station Name"
                                                name="station_name"
                                                value="{{ $troubleshoot->station_name ?? ''  }}" />

                                <x-forms.textbox type="text"
                                                label="Author"
                                                name="author"
                                                value="{{ $troubleshoot->author ?? ''  }}" />

                                <x-forms.textbox type="text"
                                                label="Designation"
                                                name="designation"
                                                value="{{ $troubleshoot->designation ?? ''  }}" />

                                <x-forms.textbox type="text"
                                                label="mobile number"
                                                name="mobile_number"
                                                value="{{ $troubleshoot->mobile_number ?? ''  }}" />

                                <x-forms.textbox type="email"
                                                label="Email"
                                                name="email"
                                                value="{{ $troubleshoot->email ?? ''  }}" />

                                @isset($troubleshoot)
                                    <x-forms.button class="btn customButton" type="submit" label="Update" icon-class="mdi mdi-redo"/>
                                @else
                                    <x-forms.button class="btn customButton" type="submit" label="Create" icon-class="mdi mdi-plus-circle"/>
                                @endisset
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
