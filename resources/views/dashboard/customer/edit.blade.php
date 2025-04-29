@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    Add Customer
@stop
@section('page-header')
    <!-- breadcrumb -->
    @foreach (['Error', 'Add', 'delete', 'edit'] as $msg)
        @if (session()->has($msg))
            <div class="alert alert-{{ $msg == 'Error' || $msg == 'delete' ? 'danger' : 'success' }} alert-dismissible fade show"
                role="alert">
                <strong>{{ session()->get($msg) }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endforeach

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add Customer</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Customer</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row -->

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="yourFormId" action="{{ route('customer.update', $cust->id) }}" method="POST"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="name" class="control-label">Name </label>
                                <input type="text" class="form-control" id="name" name="name"
                                    title="   Please enter the Customer name  " value="{{ $cust->name }}">
                            </div>
                            <div class="col">
                                <label for="abb" class="control-label">Abb </label>
                                <input type="text" class="form-control" id="abb" name="abb"
                                    title="   Please enter the customer Abb  " value="{{ $cust->abb }}">
                            </div>

                            @php
                                $all = [
                                    'GOV' => 'GOV',
                                    'PRIVATE' => 'PRIVATE',
                                ];
                            @endphp

                            <div class="col">
                                <label for="tybe" class="control-label">Type</label>
                                <select class="form-control SlectBox"onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')" id="tybe" name="tybe" required>
                                    <option value="">Select Value</option>
                                    @foreach ($all as $value)
                                        <option value="{{ $value }}"
                                            @if ($value == $cust->tybe) @selected(true) @endif>

                                            {{ $value }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="row mt-4">
                            <div class="col">
                                <div style="text-align:justify;">
                                    <div style="display: inline-flex;">
                                        <h5 class="card-title mr-3">Customer Logo</h5>
                                        <p class="text-primary">* Attachment format pdf, jpeg, .jpg, png </p>
                                    </div>

                                </div>


                                <div class="col-sm-12 col-md-12">
                                    <input type="file" name="logo" class="dropify"
                                        accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" />
                                </div><br>

                            </div>

                        </div>


                        <div class="row mt-1">
                            <div class="col">
                                <label for="customercontactname" class="control-label">Customer Contact Name </label>
                                <input type="text" class="form-control" id="customercontactname"
                                    name="customercontactname" title="   Please enter the Customer Contact Name  "    value="{{ $cust->customercontactname }}">
                            </div>


                            <div class="col">
                                <label for="customercontactposition" class="control-label">Customer Contact Position</label>
                                <input type="text" class="form-control" id="customercontactposition"
                                    name="customercontactposition" title="   Please enter the Customer Contact Position  "    value="{{ $cust->customercontactposition }}">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="email" class="control-label">Email </label>
                                <input type="email" class="form-control" id="email" name="email"
                                    title="   Please enter the Customer Email  "    value="{{ $cust->email }}">
                            </div>
                            <div class="col">
                                <label for="phone" class="control-label">Phone </label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    title="   Please enter the Customer Phone  "     value="{{ $cust->phone }}">
                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary"> Save Customer </button>
                        </div>


                    </form>
                </div>
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
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
