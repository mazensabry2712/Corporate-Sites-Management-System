
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
    Add Invoice
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add ptask </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    ptask</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif -->

    <!-- row -->

     @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 

    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="yourFormId" action="{{ route('ptasks.store') }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}



                        <div class="row mt-3">

                           
                            <div class="col">
                                <label for="invoice_number" class="control-label"> Task Date </label>
                                <input type="date" class="form-control" id="invoice_number" name="task_date"
                                    title="   Please enter the   ">
                            </div>
                          


                            <div class="col">
                                <label for="value" class="control-label">details</label>
                                <input type="text" class="form-control" id="details" name="details"
                                    title="   Please enter the details  ">
                            </div>


                          <div class="col">
                                <label for="name" class="control-label">PR Number</label>
                                <select name="pr_number" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> PR Number </option>
                                    @foreach ($projects as $pr_number_id)
                                        <option value="{{ $pr_number_id->id }}"> {{ $pr_number_id->pr_number }}</option>
                                    @endforeach
                                </select>
                            </div> 

                      
                        

                        </div>












                        <!-- <div class="row mt-4">
                            <div class="col">
                                <div style="text-align:justify;">
                                    <div style="display: inline-flex;">
                                        <h5 class="card-title mr-3">Invoice Copy (Attach) </h5>
                                        <p class="text-danger">* Attachment format pdf </p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <input type="file" name="pic" class="dropify"
                                        accept=".pdf" data-height="70" />
                                </div><br>
                            </div>
                        </div> -->
                        <div class="row mt-3">
                            <div class="col">
                                <label for="assigned" class="control-label">assigned </label>
                                <input type="text" class="form-control" id="assigned" name="assigned"
                                    title="   Please enter the Status ">
                            </div>

                            
                            <div class="col">
                                <label for="expected_com_date" class="control-label">expected_com_date </label>
                                <input type="date" class="form-control" id="expected_com_date" name="expected_com_date"
                                    title="   Please enter the expected_com_date ">
                            </div>






                            <div class="col">
                                <label for="status" class="control-label">status</label>
                                <select class="form-control SlectBox"onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')" id="status" name="status" required>
                                    <option value="">Select Value</option>
                                    <option value="completed">completed</option>
                                    <option value="pending">pending</option>
                                    <option value="progress">progress</option>
                                    <option value="hold">hold</option>
                                    
                                </select>
                            </div>

                            
                           
                        </div>


                        <br>



                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"> Save Ptask </button>
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

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'mm/dd/yy'
        }).val();
    </script>

    {{-- ds  --}}
    <script>
        $(document).ready(function() {
            $('select[name="pr_number_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('pr_number_id') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>
    {{-- /ds  --}}
@endsection
