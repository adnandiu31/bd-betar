@extends('layouts.app')

@section('title','Faqs')

@push('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

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
                <li class="nav-item">
                    <a href="{{ route('faqs.index') }}" class="btn-shadow btn btn-danger">
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
                          action="{{ isset($faq) ?  route('faqs.update',$faq->id) : route('faqs.store') }}"
                          class="forms-sample data-create-form">
                        @csrf
                        @isset($faq)
                            @method('PUT')
                        @endisset

                        <x-forms.textbox label="Question"
                                         name="question"
                                         value="{{ $faq->question ?? ''  }}"
                                         field-attributes="required autofocus">
                        </x-forms.textbox>

                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea id="answer"
                                      class="form-control @error('answer') is-invalid @enderror"
                                      name="answer" rows="5"
                            >{{ isset($faq) ? $faq->answer : old('answer') }}</textarea>
                            @error('answer')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn customButton mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
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
            selector: '#answer',
            plugins: 'print preview paste importcss searchreplace autolink directionality code visualblocks visualchars image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | preview | insertfile image media link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            image_advtab: true,
            content_css: '//www.tiny.cloud/css/codepen.min.css',
            importcss_append: true,
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
        });
    </script>
@endpush