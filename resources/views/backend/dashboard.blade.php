@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
                <span class="page-title-icon iconColor text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard
            </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('images/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Users <i class="mdi mdi-account mdi-24px float-right"></i>
                    </h4>
                    <h2>{{ $usersCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('images/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Roles <i class="mdi mdi-account-group mdi-24px float-right"></i>
                    </h4>
                    <h2>{{ $rolesCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('images/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Menus <i class="mdi mdi-menu mdi-24px float-right"></i>
                    </h4>
                    <h2>{{ $menusCount }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Last Logged In Users</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="backgroundColor: #d4d4d4">
                                <tr>
                                    <th class="text-center"></th>
                                    <th>Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Last Login At</th>
                                    {{-- <th class="text-center">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td class="text-center text-muted">#{{ $key + 1 }}</td>
                                        <td>
                                            <div class="widget-content p-0 table-data">
                                                <div style="display: flex;gap: .5rem" class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">
                                                            <img style="border: 2px solid #2c6140;borderRadius: 50% 50%; padding: .2rem "
                                                                width="45" class="rounded-circle"
                                                                src="{{ $user->getFirstMediaUrl('avatar') != null ? $user->getFirstMediaUrl('avatar', 'thumb') : config('app.placeholder') . '160' }}"
                                                                alt="User Avatar">
                                                        </div>
                                                    </div>
                                                    <div style="display: flex;gap: .5rem" class="widget-content-left flex2">
                                                        {{-- <p>{{ $user->name }}</p> --}}
                                                        <div
                                                            style="display: flex;
                                                                                            flexDirection: column;gap: .5rem">
                                                            <span><strong>{{ $user->name }}</strong></span>
                                                            <span style="font-size: 12px">{{ $user->email }}</span>

                                                        </div>
                                                        <p>
                                                            @if ($user->role)
                                                                <span
                                                                    style="font-size: 10px;backgroundColor: #2c6140;border:none"
                                                                    class="badge badge-info">{{ $user->role->name }}</span>
                                                            @else
                                                                <span class="badge badge-danger">No role found :(</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->last_login_at }}</td>
                                        {{-- <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.users.show',$user->id) }}">
                                            <i class="mdi mdi-eye"></i>
                                            <span>Details</span>
                                        </a>
                                    </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
