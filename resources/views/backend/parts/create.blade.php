@extends('layouts.app')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span> Parts </h3>
        </div>
    </div>
@endsection

@section('content')
    <Part :instruments="{{ json_encode($instruments) }}" :part_types= "{{ json_encode($partTypes) }}" :manufactures="{{json_encode($manufactures)}}"></Part>
@endsection
