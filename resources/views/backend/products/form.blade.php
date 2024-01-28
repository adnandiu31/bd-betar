@extends('layouts.app')

@section('title','Users')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Product </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row role-title-page app-page-title mb-3">
        <div class="col-12 page-title-wrapper">
            <div class="page-title-heading mt-1">
                <h4>Add Products</h4>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('product') }}" class="btn-shadow btn btn-danger">
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
                <form class="forms-sample data-create-form">
                    <div class="form-group">
                        <label for="exampleInputName1">Manufacture</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Manufacture">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Model</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Model">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Sr. No</label>
                        <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Sr. No">
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleInputCity1">Symbol No</label>
                        <input type="text" class="form-control" id="exampleInputCity1" placeholder="Symbol No">
                    </div>
                    <div class="form-group">
                        <x-forms.checkbox label="Status" name="status" class="custom-switch" />
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
