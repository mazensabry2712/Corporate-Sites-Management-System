
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
                <h4 class="content-title mb-0 my-auto">Add ppos</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    ppos</span>
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
                    <form id="yourFormId" action="{{ route('ppos.update',$ppos->id) }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        {{-- 1 --}}



                        <div class="row mt-3">

                           
                            <div class="col">
                                <label for="po_number" class="control-label"> po_number </label>
                                <input type="text" class="form-control" id="po_number" name="po_number"
                                    title="   Please enter the  po_number  " value="{{$ppos->po_number}}">
                            </div>

                            <div class="col">
                                <label for="name" class="control-label">category</label>
                                <select name="category" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> category </option>
                                    @foreach ($pepos as $pr_number_id)
                                        <option value="{{ $pr_number_id->id }}"   @selected($ppos->category == $pr_number_id->id) > {{ $pr_number_id->id }}</option>
                                    @endforeach
                                </select>
                            </div> 

                
                          <div class="col">
                                <label for="name" class="control-label">supplier_name</label>
                                <select name="supplier_name" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> PR Number </option>
                                    @foreach ($ds as $pr_number_id)
                                        <option value="{{ $pr_number_id->id }}" @selected($ppos->supplier_name == $pr_number_id->id)> {{ $pr_number_id->dsname }}</option>
                                    @endforeach
                                </select>
                            </div> 

                      
                        

                        </div>
                         <div class="row mt-3">

                           
                            <div class="col">
                                <label for="date" class="control-label">  Date </label>
                                <input type="date" class="form-control" id="date" name="date"
                                    title="   Please enter the   " value="{{$ppos->date}}">
                            </div>
                          


                            <div class="col">
                                <label for="updates" class="control-label">updates</label>
                                <input type="text" class="form-control" id="updates" name="updates"
                                    title="   Please enter the updates  " value="{{$ppos->updates}}">
                            </div>


                          <div class="col">
                                <label for="name" class="control-label">PR Number</label>
                                <select name="pr_number" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> PR Number </option>
                                    @foreach ($projects as $pr_number_id)
                                        <option value="{{ $pr_number_id->id }}" @selected($ppos->pr_number == $pr_number_id->id)> {{ $pr_number_id->pr_number }}</option>
                                    @endforeach
                                </select>
                            </div> 

                      
                        

                        </div>













                    
                        <div class="row mt-3">
                            <div class="col">
                                <label for="value" class="control-label">value </label>
                                <input type="number" class="form-control" id="value" name="value"
                                    title="   Please enter the value " value="{{$ppos->value}}">
                            </div>

                           
                            <div class="col">
                                <label for="notes" class="control-label">notes </label>
                                <input type="text" class="form-control" id="notes" name="notes"
                                    title="   Please enter the notes " value="{{$ppos->notes}}">
                            </div>






                            <div class="col">
                                <label for="status" class="control-label">Status </label>
                                <input type="text" class="form-control" id="status" name="status"
                                    title="   Please enter the Status " value="{{$ppos->status}}">
                            </div>


                            
                           
                        </div>


                        <br>



                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"> update ppos </button>
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
