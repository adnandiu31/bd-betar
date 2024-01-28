@extends('layouts.app')

@section('title', 'Parts')

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
                <span class="page-title-icon iconColor text-white mr-2">
                    <i class="mdi mdi-basket"></i>
                </span> Parts
            </h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <a href="{{ route('admin.parts.index') }}" class="btn-shadow btn btn-danger">
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
            <div class="card shadow" style="border: 1px solid #cfcfcf">
                <div class="card-body">
                    <!-- form start -->
                    <form method="POST"
                        action="{{ isset($part) ? route('admin.parts.update', $part->id) : route('admin.parts.store') }}"
                        class="forms-sample data-create-form" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @isset($part)
                            @method('PUT')
                        @endisset


                        {{-- <x-forms.textbox class=" " label="Part Name" name="name" id="" value="{{ $part->name ?? '' }}"
                            field-attributes="required">
                        </x-forms.textbox> --}}
                        <input type="text" name="name" id="part_name" class="form-control mb-3" value="{{ $part->name ?? '' }}" placeholder="Enter Part Name..." autocomplete="off" />

                        <div id="testClass" class="search-result">

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.select label="Instrument" name="instrument" class="select js-example-basic-single "
                                    id="instrument">
                                    @foreach ($instruments as $key => $instrument)
                                        <x-forms.select-item :value="$instrument->id" :label="$instrument->name"
                                            :selected="$instrument->partType->id ?? null" />
                                    @endforeach
                                </x-forms.select>
                            </div>

                            {{-- <x-forms.select label="Select Station" --}}
                            {{-- name="station" --}}
                            {{-- class="select js-example-basic-single"> --}}
                            {{-- @foreach ($stations as $key => $station) --}}
                            {{-- <x-forms.select-item :value="$station->id" :label="$station->name" :selected="$part->station->id ?? null"/> --}}
                            {{-- @endforeach --}}
                            {{-- </x-forms.select> --}}

                            <div class="col-md-6">
                                <x-forms.select label="Select Type" name="part_type" class=" select js-example-basic-single"
                                    id="part_type">
                                    @foreach ($partTypes as $key => $partType)
                                        <x-forms.select-item :value="$partType->id" :label="$partType->name"
                                            :selected="$partType->partType->id ?? null" />
                                    @endforeach
                                </x-forms.select>
                            </div>
                        </div>

                        {{-- <x-forms.select label="Select Part Name"
                                        name="part_name"
                                        id="part_name"
                                        class="select js-example-basic-single">
                            @foreach ($parts as $key => $part)
                                <x-forms.select-item :value="$part->id" :label="$part->name" :selected="$part->part->id ?? null"/>
                            @endforeach
                        </x-forms.select> --}}

                        {{-- <x-forms.select label="Select Part Namess"
                                        name="part_name"
                                        id="part_name"
                                        list="part_name"
                                        class="select js-example-basic-single">
                         
                                        @foreach ($parts as $key => $part)
                                            <x-forms.select-item :value="$part->id" :label="$part->name" :selected="$part->part->id ?? null"/>
                                            @endforeach                
                        </x-forms.select> --}}


                        {{-- <label class="form-label" for="browser">Choose your browser from the list:</label>
                        <input class="form-control mb-2" list="browsers" name="browser" id="browser">
                        <datalist id="browsers">
                            @foreach ($parts as $key => $part)
                            <option value="{{$part->name}}"  selected="$part->part->id ?? null" >
                            @endforeach
                        </datalist> --}}

                        {{-- <label for="part">Select Part Name</label><br>
                        <select class="form-control formselect mb-2 required" name="part" placeholder="Select Part Name" id="part_name"
                        >
                      </select> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.select label="Select Manufacture" name="manufacture"
                                    class="select js-example-basic-single">
                                    @foreach ($manufactures as $key => $manufacture)
                                        <x-forms.select-item :value="$manufacture->id" :label="$manufacture->name"
                                            :selected="$part->manufacture->id ?? null" />
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div class="col-md-6">
                                <x-forms.textbox label="Parts No" name="parts_no" value="{{ $part->parts_no ?? '' }}">
                                </x-forms.textbox>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.textbox label="Specification" name="specification"
                                    value="{{ $part->specification ?? '' }}">
                                </x-forms.textbox>
                            </div>
                            <div class="col-md-6">
                                <x-forms.textbox label="Designation" name="designation" class="readonly"
                                    value="{{ $part->designation ?? '' }}">
                                </x-forms.textbox>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <x-forms.textbox label="Ledger Information" name="ledger_information"
                                    value="{{ $part->ledger_information ?? '' }}">
                                </x-forms.textbox>
                            </div>
                            <div class="col-md-3">
                                <x-forms.textbox label="Purchase Date" type="date" name="purchase_date"
                                    value="{{ $part->purchase_date ?? '' }}">
                                </x-forms.textbox>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.textbox label="Parts Pos" name="parts_pos" value="{{ $part->parts_pos ?? '' }}">
                                </x-forms.textbox>
                            </div>
                            <div class="col-md-6">
                                {{-- <x-forms.textbox type="number" label="Quantity" name="quantity"
                                    value="{{ $part->quantity ?? '' }}">
                                </x-forms.textbox> --}}

                                <label class="form-label" for="quantity">Quantity</label>
                                <input class="form-control mb-4" type="number" name="quantity" value="{{ $part->quantity ?? '' }}" {{ isset($part->quantity) && $part->quantity > 0 ? 'readonly' : '' }} >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {{-- <x-forms.textbox type="number" label="Number in use" name="in_use"
                                    value="{{ $part->in_use ?? '' }}">
                                </x-forms.textbox> --}}

                                <label class="form-label" for="in_use">Number in use</label>
                                <input class="form-control mb-4" type="number" name="in_use" value="{{ $part->in_use ?? '' }}" {{ isset($part->in_use) ? 'readonly' : '' }} >
                            </div>
                            <div class="col-md-6">
                                
                                <label class="form-label" for="present_stock">Present Stock</label>
                                <input class="form-control mb-4" type="number" name="present_stock" value="{{ $part->present_stock ?? '' }}" {{ isset($part->present_stock) ? 'readonly' : '' }} >
                            </div>
                        </div>
                        <x-forms.textbox label="Description" name="description" value="{{ $part->description ?? '' }}">
                        </x-forms.textbox>
                        <x-forms.textbox label="Comments" name="comments" value="{{ $part->comments ?? '' }}">
                        </x-forms.textbox>
                        <x-forms.textbox label="Attached a file" type="file" name="parts_attached_file">
                        </x-forms.textbox>

                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script>
    <script>
        // var path = "{{ route('admin.part.autocomplete') }}";
        // $('input#part_name').typeahead({
        //     highlight: false,
        //     source:  function (query, process) {
        //     return $.get(path, { query: query }, function (data) {
        //             console.log("Ok with me",data);
        //             $('#testClass').fadeIn(); 
        //             $('#testClass').html(data);
        //             return process(data);


        //         });
        //     }
        // });
        // $(document).on('click', 'a', function(){  
        //     $('#part_name').val($(this).text());  
        //     $('#testClass').fadeOut();  
        //     console.log('all id ok');
        // });


        $(document).ready(function(){

            $('#part_name').keyup(function(){ 
                var query = $(this).val();
                if(query.length >= 0)
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('admin.part.autocomplete') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        console.log(data.length);
                        $('#testClass').fadeIn();  
                        $('#testClass').html(data);
                        console.log('ok',data);
                    }
                    });
                }
            });

            // $(document).on('click', 'a', function(e){ 
            //     $('#part_name').val($(this).text());  
            //     $('#testClass').fadeOut();  
            //     console.log('all is ok'); 

            //     var target = e.target; 
            //     if(!jQuery(target).is('#testClass')) {
            //         $('#part_name').val($(this).text());  
            //         $('#testClass').fadeOut();   
            //         console.log('all is ok'); 
            //     }  
                
            // });  

        });
    </script>
@endpush
