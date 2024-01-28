@extends('layouts.app')

@section('title','Forum')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-help"></i>
              </span> Details </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('forum.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                      <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="mdi mdi-arrow-left"></i>
                    </span>
                    </span>
                        Back To List
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
                                <div class="col-sm-9 col-lg-6 mt-4">
                                    <a class=" text-success ">{!! $question->question !!}</a>
                                  </div>
                                <div class="col-sm-6 col-lg-3 mt-4">
                                  <div class="wrapper d-flex">
                                    <div class="wrapper pl-2 d-none d-sm-block">
                                      @if($question->user->id==auth()->user()->id)
                                      <div class="row">
                                        <div class="col-sm-6 text-white">
                                          <a class="btn customButton btn-sm"
                                          href="{{ route('forum.edit',$question->id) }}"><i
                                               class="mdi mdi-pencil"></i>
                                           <span>Edit</span>
                                       </a>
                                        </div>
                                        <div class="col-sm-6 ">
                                          <button type="button" class=" btn btn-danger btn-sm"
                                          onclick="deleteData({{ $question->id }})">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Delete</span>
                                        </button>
                                        </div>
                                      </div>


                                      @else
                                        <h6 class="mt-n1 mb-0 font-weight-medium text-center">{{ $question->replies()->count() }}</h6>
                                        <p class="text-muted">Replies</p>
                                        @endif
                                      </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <form id="delete-form-{{ $question->id }}"
              action="{{ route('forum.destroy',$question->id) }}"
              method="POST"
              style="display: none;">
            @csrf()
            @method('DELETE')
            </form>
              <div class="card">
              <div class="card-body">  
              <div class="col-12 mb-5 mt-4">
                <h2>Replies</h2>
              </div>
              @forelse($question->replies as $key => $reply)
              <div class="col-12 results">
                <div class="pt-4 border-top @if(!$key%2==0)text-right @endif">
                  <a class="d-block h4 mb-0" href="">{{ $reply->user->name }}</a>
                  <p class="page-url text-primary" href="">{{  $reply->created_at->diffForHumans() }}</p>
                <p class="page-description mt-1 w-75 text-muted">{!! $reply->reply !!}</p>
                @if($reply->user->id==auth()->user()->id)
                <button type="button" class="btn btn-danger btn-sm mb-2"
                  onclick="deleteReply({{ $reply->id }})">
                    <i class="mdi mdi-delete"></i>
                    <span>Delete</span>
                </button>
                <form id="delete-reply-form-{{ $reply->id }}"
                  action="{{ route('replies.destroy',$reply->id) }}"
                  method="POST"
                  style="display: none;">
                @csrf()
                @method('DELETE')
            </form>
                @endif
                </div>
              </div>
              @empty
              <div class="col-12 mb-5 mt-4">
                <p class="">opps!!None replied yet!!</p> 
              </div>
               
              @endforelse
              </div>
            </div>
            <div class="card mt-2">
              <div class="card-body">
                  <!-- form start -->
                  <form method="POST"
                        action="{{ route('replies.store') }}"
                        class="forms-sample data-create-form">
                      @csrf
                
                      <input type="hidden" value="{{ $question->id }}" name="forum_id">
                      <div class="form-group">
                          <label for="reply">Post Your reply</label>
                          <textarea id="reply"
                                    class="form-control @error('reply') is-invalid @enderror"
                                    name="reply" rows="5"
                          >{{ old('reply') }}</textarea>
                          @error('reply')
                          <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                          @enderror
                      </div>
                      <button type="submit" class="btn customButton mr-2">Submit</button>
                  </form>
              </div>
          </div>
            </div>
        </div>
@endsection

@push('js')
<script src="https://cdn.tiny.cloud/1/g1axuf87kmcxy93m2ynfmp3usxm3k0mrzcdmm62m0f3pfme3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#reply',
        plugins: 'print preview paste importcss searchreplace autolink directionality code visualblocks visualchars image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | preview | insertfile image media link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        image_advtab: true,
        content_css: '//www.tiny.cloud/css/codepen.min.css',
        importcss_append: true,
        height: 250,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: "mceNonEditable",
        toolbar_mode: 'sliding',
        contextmenu: "link image imagetools table",
    });
</script>
<script>

</script>
@endpush
