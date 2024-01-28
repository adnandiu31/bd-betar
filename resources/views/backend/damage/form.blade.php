@extends('layouts.app')

@section('title','Instruments')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Parts damage </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
{{--                    <a href="{{ route('admin.instruments.index') }}" class="btn-shadow btn btn-danger">--}}
{{--                    <span class="btn-icon-wrapper pr-2 opacity-7">--}}
{{--                        <i class="mdi mdi-arrow-left"></i>--}}
{{--                    </span>--}}
{{--                        Back to list--}}
{{--                    </a>--}}
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
                          action="{{ route('storekeeper.sib.damage.update') }}"
                          class="forms-sample data-create-form" enctype="multipart/form-data" >
                        @csrf
                       <div class="row">
                        <div class="col-md-6">
                            <x-forms.select label="Select Part"
                                    name="part_id"
                                    class="select js-example-basic-single">
                                @foreach($parts as $key=>$part)
                                    <x-forms.select-item :value="$part->id" :label="$part->name" :selected="$part->id ?? null"/>
                                @endforeach
                            </x-forms.select>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-9">
                                <label for="demage_quantity">Damage quantity</label>
                                <input class="form-control" id="demage_quantity" name="demage_quantity" type="number" />
                            </div>
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
