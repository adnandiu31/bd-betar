@extends('layouts.app')

@section('title','Instruments')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Instruments </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.instruments.index') }}" class="btn-shadow btn btn-danger">
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
                    <!-- form start -->
                    <form method="POST"
                          action="{{ isset($instrument) ?  route('admin.instruments.update',$instrument->id) : route('admin.instruments.store') }}"
                          class="forms-sample data-create-form" enctype="multipart/form-data" >
                        @csrf
                        @isset($instrument)
                            @method('PUT')
                        @endisset

                        {{-- <x-forms.textbox label="Instrument Id"
                                         name="instrument_id"
                                         value="{{ $instrument->instrument_id ?? ''  }}"
                                         field-attributes="required autofocus">
                        </x-forms.textbox> --}}

                        <x-forms.textbox label="Instrument Name"
                                         name="name"
                                         value="{{ $instrument->name ?? ''  }}"
                                         field-attributes="required">
                        </x-forms.textbox>

                       {{-- <x-forms.select label="Select Station"
                                       name="station"
                                       class="select js-example-basic-single">
                           @foreach($stations as $key=>$station)
                               <x-forms.select-item :value="$station->id" :label="$station->name" :selected="$instrument->station->id ?? null"/>
                           @endforeach
                       </x-forms.select> --}}
                       <div class="row">
                        <div class="col-md-6">
                            <x-forms.select label="Select Type"
                                    name="type"
                                    class="select js-example-basic-single">
                            @foreach($instrumentsTypes as $key=>$instrumentsType)
                                <x-forms.select-item :value="$instrumentsType->id" :label="$instrumentsType->name" :selected="$instrument->instrumentsType->id ?? null"/>
                            @endforeach
                        </x-forms.select>
                        </div>

                        <div class="col-md-6">
                            <x-forms.select label="Select Manufacture"
                            name="manufacture"
                            class="select js-example-basic-single">
                                @foreach($manufactures as $key=>$manufacture)
                                    <x-forms.select-item :value="$manufacture->id" :label="$manufacture->name" :selected="$instrument->manufacture->id ?? null"/>
                                @endforeach
                            </x-forms.select>
                        </div>
                    </div>

                        <div class="row">
                            <div class="col-md-9">
                                <x-forms.textbox label="Description"
                                         name="description"
                                         value="{{ $instrument->description ?? ''  }}">
                                </x-forms.textbox>
                            </div>

                            <div class="col-md-3">
                                <x-forms.textbox label="Installation Date"
                                            type="date"
                                            name="installation_date"
                                            value="{{ $instrument->installation_date ?? ''  }}">
                                </x-forms.textbox>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.textbox label="Model"
                                         name="model"
                                         value="{{ $instrument->model ?? ''  }}">
                                </x-forms.textbox>
                            </div>

                            <div class="col-md-6">
                                <x-forms.textbox label="Serial No"
                                            name="serial_no"
                                            value="{{ $instrument->serial_no ?? ''  }}">
                                </x-forms.textbox>
                            </div>
                        </div>

                       <x-forms.textbox label="Attached a file"
                                        type="file"
                                        name="attached_file"
                                        >
                       </x-forms.textbox>

                        <button type="submit" class="btn customButton mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
