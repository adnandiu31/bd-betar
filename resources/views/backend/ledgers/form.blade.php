@extends('layouts.app')

@section('title','Ledgers')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Ledger </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row role-title-page app-page-title mb-3">
        <div class="col-12 page-title-wrapper">
            <div class="page-title-heading mt-1">
                <h4>Add Ledgers</h4>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.ledgers.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="mdi mdi-arrow-left"></i>
                    </span>
                    Back to list
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form method="POST"
                          action="{{ isset($ledger) ?  route('admin.ledgers.update',$ledger->id) : route('admin.ledgers.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($ledger)
                            @method('PUT')
                        @endisset
                        <x-forms.select label="Select Station"
                                        name="station"
                                        class="select js-example-basic-single">
                            @foreach($stations as $key=>$station)
                                <x-forms.select-item :value="$station->id" :label="$station->name" :selected="$ledger->station->id ?? null"/>
                            @endforeach
                        </x-forms.select>

                        <x-forms.textbox label="New Address"
                                         name="address"
                                         value="{{ $ledger->address ?? ''  }}"
                                         field-attributes="required">
                        </x-forms.textbox>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
