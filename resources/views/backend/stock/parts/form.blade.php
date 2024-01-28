@extends('layouts.app')

@section('title','Parts')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Parts </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.stock.parts.index') }}" class="btn-shadow btn btn-danger">
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
                          action="{{ isset($stockPart) ?  route('admin.stock.parts.update',$stockPart->id) : route('admin.stock.parts.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($stockPart)
                            @method('PUT')
                        @endisset

                        {{-- <x-forms.select label="Select Station"
                                        name="station"
                                        class="select js-example-basic-single">
                            @foreach($stations as $key=>$station)
                                <x-forms.select-item :value="$station->id" :label="$station->name" :selected="$stockPart->station->id ?? null"/>
                            @endforeach
                        </x-forms.select> --}}

                        <x-forms.select label="Select Part"
                                        name="part"
                                        class="select js-example-basic-single">
                            @foreach($parts as $key=>$part)
                                <x-forms.select-item :value="$part->id" :label="$part->name" :selected="$stockPart->part->id ?? null"/>
                            @endforeach
                        </x-forms.select>

                        <x-forms.textbox label="Quantity"
                                         type="number"
                                         name="quantity"
                                         value="{{ $stockPart->quantity ?? ''  }}">
                        </x-forms.textbox>

                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
