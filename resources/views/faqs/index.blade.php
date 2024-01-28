@extends('layouts.app')

@section('title','Faqs')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-help"></i>
              </span> Faqs </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                @role('admin')
                <li class="customButton">
                    <a href="{{ route('faqs.create') }}" class="">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add Faq Question
                    </a>
                </li>
                @endrole
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Faqs</h4>
                  <div class="mt-4">
                        <div class="accordion accordion-solid-header" id="accordion" role="tablist">
                            @forelse($faqs as $key=>$faq)
                            <div class="card">
                                <div class="card-header " role="tab" id="heading_{{ $faq->id }}">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse_{{ $faq->id }}" aria-expanded="false" aria-controls="collapse_{{ $faq->id }}"> {{ $faq->question }} </a>
                                    </h6>
                                </div>
                                <div id="collapse_{{ $faq->id }}" class="collapse" role="tabpanel" aria-labelledby="heading_{{ $faq->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        @role('admin')
                                        <a class="btn customButton btn-sm"
                                           href="{{ route('faqs.edit',$faq->id) }}"><i
                                                class="mdi mdi-pencil"></i>
                                            <span>Edit</span>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $faq->id }})">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Delete</span>
                                        </button>
                                        <form id="delete-form-{{ $faq->id }}"
                                              action="{{ route('faqs.destroy',$faq->id) }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                        <div class="mb-3">
                                            <br>
                                        </div>
                                        @endrole
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="text-center">
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
