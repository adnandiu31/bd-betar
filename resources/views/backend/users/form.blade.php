@extends('layouts.app')

@section('title','Users')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-account-circle"></i>
              </span> {{ __((isset($user) ? 'Edit' : 'Create New') . ' User') }} </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="btn-shadow btn btn-danger">
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
            <!-- form start -->
            <form role="form" id="userFrom" method="POST"
                  action="{{ isset($user) ? route('admin.users.update',$user->id) : route('admin.users.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">User Info</h5>

                                <x-forms.textbox label="Name"
                                                 name="name"
                                                 value="{{ $user->name ?? ''  }}"
                                                 field-attributes="required autofocus">
                                </x-forms.textbox>

                                <x-forms.textbox type="email"
                                                 label="Email"
                                                 name="email"
                                                 value="{{ $user->email ?? ''  }}" />

                                <div class="row">
                                    <div class="col-md-6">
                                        <x-forms.textbox type="password"
                                                 label="Password"
                                                 name="password"
                                                 placeholder="******" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-forms.textbox type="password"
                                                 label="Confirm Password"
                                                 name="password_confirmation"
                                                 placeholder="******" />
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Select Role and Status</h5>

                                <x-forms.select label="Select Role"
                                                name="role"
                                                class="select js-example-basic-single">
                                    @foreach($roles as $key=>$role)
                                        <x-forms.select-item :value="$role->id" :label="$role->name" :selected="$user->role->id ?? null"/>
                                    @endforeach
                                </x-forms.select>

                                <x-forms.select label="Select Station"
                                                name="station"
                                                class="select js-example-basic-single">

                                @foreach($stations as $key=>$station)
                                        <x-forms.select-item :value="$station->id" :label="$station->name" :selected="$user->station->id ?? null"/>
                                    @endforeach
                                </x-forms.select>

                                <div class="form-group">
                                    <label for="avatar">Avatar (Only Image are allowed)</label>
                                    <input type="file" name="avatar" id="avatar"
                                           class="dropify @error('avatar') is-invalid @enderror"
                                           data-default-file="{{ isset($user) ? $user->getFirstMediaUrl('avatar','thumb') : ''  }}">
                                    @error('avatar')
                                    <span class="text-danger" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="signature">Signature (Only Image are allowed)</label>
                                    <input type="file" name="signature" id="avatar"
                                           class="dropify @error('signature') is-invalid @enderror"
                                           data-default-file="{{ isset($user) ? $user->getFirstMediaUrl('signature','thumb1') : ''  }}">
                                    @error('signature')
                                    <span class="text-danger" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                    @enderror
                                </div>
                                <x-forms.checkbox label="Status"
                                                  name="status"
                                                  class="custom-switch"
                                                  :value="$user->status ?? null" />


                                <x-forms.button label="Reset" class="btn-danger" icon-class="fas fa-redo" on-click="resetForm('userFrom')"/>


                                @isset($user)
                                    <x-forms.button type="submit" label="Update" icon-class="mdi mdi-redo"/>
                                @else
                                    <x-forms.button type="submit" label="Create" icon-class="mdi mdi-plus-circle"/>
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
