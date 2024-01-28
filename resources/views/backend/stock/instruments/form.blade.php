@extends('layouts.app')

@section('title','Instruments')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Instruments </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.stock.instruments.index') }}" class="btn-shadow btn btn-danger">
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
                          action="{{ isset($stockInstrument) ?  route('admin.stock.instruments.update',$stockInstrument->id) : route('admin.stock.instruments.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($stockInstrument)
                            @method('PUT')
                        @endisset

                        {{-- <x-forms.select label="Select Station"
                                        name="station"
                                        class="select js-example-basic-single">
                            @foreach($stations as $key=>$station)
                                <x-forms.select-item :value="$station->id" :label="$station->name" :selected="$stockInstrument->station->id ?? null"/>
                            @endforeach
                        </x-forms.select> --}}

                        <x-forms.select label="Select Instrument"
                                        name="instrument"
                                        class="select js-example-basic-single">
                            @foreach($instruments as $key=>$instrument)
                                <x-forms.select-item :value="$instrument->id" :label="$instrument->name" :selected="$stockInstrument->instrument->id ?? null"/>
                            @endforeach
                        </x-forms.select>

                        <x-forms.textbox label="Quantity"
                                         type="number"
                                         name="quantity"
                                         value="{{ $stockInstrument->quantity ?? ''  }}">
                        </x-forms.textbox>

                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
