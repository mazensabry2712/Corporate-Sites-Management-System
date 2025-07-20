@extends('layouts.master')
@section('title')
    Edit PPO
@stop
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/sugarjs/plugin.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                Edit PPO</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <a class="btn btn-info btn-sm" href="{{ route('ppos.index') }}"> PPOs List</a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row opened -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ppos.index') }}"> Back</a>
                        </div>
                    </div><br>

                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                        action="{{ route('ppos.update', $ppos->id) }}" method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}

                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6">
                                    <label> Project Number: <span class="tx-danger">*</span></label>
                                    <select name="pr_number" id="pr_number" class="form-control select2" required>
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ $ppos->pr_number == $project->id ? 'selected' : '' }}>
                                                {{ $project->pr_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                    <label> Category: <span class="tx-danger">*</span></label>
                                    <select name="category" id="category" class="form-control select2" required>
                                        <option value="">Select Category</option>
                                        @foreach ($pepos as $pepo)
                                            <option value="{{ $pepo->id }}"
                                                {{ $ppos->category == $pepo->id ? 'selected' : '' }}>
                                                {{ $pepo->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6">
                                    <label> Supplier Name: </label>
                                    <select name="supplier_name" id="supplier_name" class="form-control select2">
                                        <option value="">Select Supplier</option>
                                        @foreach ($ds as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ $ppos->supplier_name == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->dsname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                    <label> PO Number: <span class="tx-danger">*</span></label>
                                    <input class="form-control form-control-sm mg-b-20"
                                           data-parsley-class-handler="#lnWrapper"
                                           name="po_number"
                                           required
                                           type="text"
                                           value="{{ $ppos->po_number }}">
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6">
                                    <label> Value: </label>
                                    <input class="form-control form-control-sm mg-b-20"
                                           data-parsley-class-handler="#lnWrapper"
                                           name="value"
                                           type="number"
                                           step="0.01"
                                           value="{{ $ppos->value }}">
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                    <label> Date: </label>
                                    <input class="form-control form-control-sm mg-b-20"
                                           data-parsley-class-handler="#lnWrapper"
                                           name="date"
                                           type="date"
                                           value="{{ $ppos->date }}">
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-12">
                                    <label> Status: </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ $ppos->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Pending" {{ $ppos->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ $ppos->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ $ppos->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-12">
                                    <label> Updates: </label>
                                    <textarea class="form-control form-control-sm mg-b-20"
                                              name="updates"
                                              rows="3">{{ $ppos->updates }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-12">
                                    <label> Notes: </label>
                                    <textarea class="form-control form-control-sm mg-b-20"
                                              name="notes"
                                              rows="3">{{ $ppos->notes }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!--Internal  Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <script>
        $('#selectForm2').parsley();
    </script>
@endsection
