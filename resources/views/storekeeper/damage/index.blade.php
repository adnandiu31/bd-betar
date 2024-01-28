@extends('layouts.app')

@section('title','sibs')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('header')
    <div class="navbar-bottom">
        <div class="page-title-wrapper">
            <h3 class="page-title">
              <span class="page-title-icon iconColor text-white mr-2">
                <i class="mdi mdi-basket"></i>
              </span> Damage part</h3>
        </div>
        <div class="navbar-menu-wrapper d-flex flex-grow">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn customButton" data-toggle="modal" data-target="#exampleModal">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                    <i class="mdi mdi-plus-circle"></i>
                    </span>
                        Add damage part
                    </button>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New sib Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST"  action="{{ route('storekeeper.sib.damage.update') }}">
                    @csrf
                    <div class="modal-body">
                        <x-forms.select label="Product Type"
                                        name="part_id"
                                        class="">
                            @foreach($parts as $key=>$part)
                                <x-forms.select-item :value="$part->id" :label="$part->name" :selected="$part->id ?? null"/>
                            @endforeach
                        </x-forms.select>

                        <div >
                            <label for="demage_quantity">Damage quantity</label>
                            <input class="form-control" id="demage_quantity" name="demage_quantity" type="number" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn customButton">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Part name</th>
                            <th class="text-center">Damage quantity</th>
                            <th class="text-center">Entry time</th>
                            <th class="text-center">Done by</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sibs as $key=>$sib)
                            <tr>
                                <td class="text-center text-muted">{{ $key + 1 }}</td>
                                <td class="text-center">{{ ucfirst($sib->part->name) }}</td>
                                <td class="text-center">{{ ucfirst($sib->quantity) }}</td>
                                <td class="text-center">{{ ucfirst($sib->entry_time) }}</td>
                                <td class="text-center">{{ ucfirst($sib->done_by) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Datatable
            $("#datatable").DataTable();
        });
    </script>
@endpush
