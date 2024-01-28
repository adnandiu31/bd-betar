@extends('layouts.app')

@section('title','Forum')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-help"></i>
              </span> Forum </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="customButton">
                    <a href="{{ route('forum.create') }}" class="">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Forum Question
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="accordion" id="accordionExample">
                    @forelse($questions as $key=>$question)

                    <div class="card">
                        <div class="card-header" id="headingOne_{{ $question->id }}">
                            <div class="row">
                                <div class="col-sm-3 col-lg-3 d-lg-flex">
                                  <div class="user-avatar mb-auto">
                                    <img src="{{ $question->user->getFirstMediaUrl('avatar') != null ? $question->user->getFirstMediaUrl('avatar','thumb') : config('app.placeholder').'160' }}" alt="User Avatar" class="profile-img img-lg rounded-circle">
                                  </div>
                                  <div class="wrapper pl-lg-4 mt-4">
                                    <div class="wrapper d-flex align-items-center">
                                      <h4 class="mb-0 font-weight-medium">{{ $question->user->name }}</h4>
                                    </div>
                                    <div class="wrapper d-flex align-items-center font-weight-medium text-muted">
                                        <p class="mb-0 text-muted">{{ $question->updated_at->diffForHumans() }}</p>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-sm-9 col-lg-7 mt-4">
                                    <a href="{{ route('forum.show',$question->id) }}" class=" text-success ">{!! $question->question !!}</a>
                                  </div>
                                <div class="col-sm-6 col-lg-2 mt-4">
                                  <div class="wrapper d-flex">
                                    <div class="wrapper pl-2 d-none d-sm-block">
                                        <h6 class="mt-n1 mb-0 font-weight-medium text-center">{{ $question->replies()->count() }}</h6>
                                        <p class="text-muted">Replies</p>
                                      </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                    @empty
                       <div class="text-center p-2">
                           <strong>No question yet.</strong>
                       </div>
                    @endforelse
                </div>


            </div>
           <div class="text-center">
               {{ $questions->links() }}
           </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
