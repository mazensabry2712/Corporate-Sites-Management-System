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
    Add Project
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add Project</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Projects</span>
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

    <!-- row -->
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

    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="yourFormId" action="{{ route('project.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                <label for="pr_number" class="control-label">PR Number </label>
                                <input type="number" class="form-control" id="pr_number" name="pr_number"
                                    title="    Please enter the project number  ">
                            </div>
                            <div class="col">
                                <label for="name" class="control-label">PR Name </label>
                                <input type="text" class="form-control" id="name" name="name"
                                    title="   Please enter the project name  ">
                            </div>
                            <div class="col">
                                <label for="technologies" class="control-label">Technologies </label>
                                <input type="text" class="form-control" id="technologies" name="technologies"
                                    title="   Please enter the project technologies  ">
                            </div>




                            <div class="col">
                                <label for="vendors" class="control-label"> Vendorsr </label>
                                <select name="vendors_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> Vendors </option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"> {{ $vendor->vendors }}</option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                    type="text" required>
                            </div> --}}
                        </div>



                        <div class="row mt-3">

                            <div class="col">
                                <label for="ds" class="control-label">Suppliers</label>
                                <select name="ds_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> Suppliers </option>
                                    @foreach ($ds as $dss)
                                        <option value="{{ $dss->id }}"> {{ $dss->dsname }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col">
                                <label for="name" class="control-label">Customer Name</label>
                                <select name="cust_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> Customer Name </option>
                                    @foreach ($custs as $cust)
                                        <option value="{{ $cust->id }}"> {{ $cust->name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col">
                                <label for="customer_po" class="control-label">Customer PO# </label>
                                <input type="text" class="form-control" id="customer_po" name="customer_po"
                                    title="   Please enter the  customer po  ">
                            </div>
                            <div class="col">
                                <label for="value" class="control-label">Value </label>
                                <input type="number" class="form-control" id="value" name="value"
                                    title="   Please enter the project value  ">
                            </div>

                        </div>






                        <div class="row mt-3">



                            <div class="col">
                                <label for="name" class="control-label">AC Manager </label>
                                <select name="aams_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> AC Manager </option>
                                    @foreach ($aams as $aam)
                                        <option value="{{ $aam->id }}"> {{ $aam->name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col">
                                <label for="name" class="control-label"> Project Manager </label>
                                <select name="ppms_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> Project Manager </option>
                                    @foreach ($ppms as $ppm)
                                        <option value="{{ $ppm->id }}"> {{ $ppm->name }}</option>
                                    @endforeach
                                </select>
                            </div>






                            <div class="col">
                                <label for="customer_contact_details" class="control-label">Customer contact details
                                </label>
                                <input type="text" class="form-control" id="customer_contact_details"
                                    name="customer_contact_details" title="   Please enter the  customer po  ">
                            </div>

                        </div>


                        <div class="row mt-4">
                            <div class="col">
                                <div style="text-align:justify;">
                                    <div style="display: inline-flex;">
                                        <h5 class="card-title mr-3">PO attachment</h5>
                                        <p class="text-primary">* Attachment format jpeg, .jpg, png </p>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <input type="file" name="po_attachment" class="dropify"
                                        accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                </div><br>

                            </div>

                            <div class="col">

                                <div style="text-align:justify;">
                                    <div style="display: inline-flex;">
                                        <h5 class="card-title mr-3 ">EPO attachment</h5>
                                        <p class="text-primary">* Attachment format jpeg, .jpg, png </p>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <input type="file" name="epo_attachment" class="dropify"
                                        accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" />
                                </div><br>

                            </div>


                        </div>

                        <div class="row">

                            <div class="col">
                                <label>Customer PO date </label>
                                <input class="form-control fc-datepicker"id="customer_po_date" name="customer_po_date"
                                    placeholder="YYYY-MM-DD" type="text" value="{{ date('Y-m-d') }}" required>
                            </div>



                            <div class="col">
                                <label for="customer_po_duration" class="control-label">Customer PO duration </label>
                                <input type="number" class="form-control" id="customer_po_duration"
                                    name="customer_po_duration" title="   Please enter the  Customer PO duration ">
                            </div>


                            <div class="col">
                                <label for="customer_po_duration" class="control-label fc-datepicker">Customer PO
                                    deadline </label>
                                <input type="text" class="form-control" id="customer_po_deadline"
                                    name="customer_po_deadline" title="   Please enter the  Customer PO deadline"
                                    value="{{ date('Y-m-d') }}"readonly>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col mt-3">
                                <label for="description">Nots</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"> Save Project </button>
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
            dateFormat: 'dd/mm/yy'
        }).val();
    </script>
    {{-- ds  --}}
    <script>
        $(document).ready(function() {
            $('select[name="ds_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('ds_id') }}/" + SectionId,
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


    {{-- vendor  --}}
    <script>
        $(document).ready(function() {
            $('select[name="vendors_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('vendors_id') }}/" + SectionId,
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
    {{-- /vendor  --}}







    {{-- cust  --}}
    <script>
        $(document).ready(function() {
            $('select[name="cust_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('cust_id') }}/" + SectionId,
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
    {{-- /cust  --}}






    {{-- cust  --}}
    <script>
        $(document).ready(function() {
            $('select[name="aams_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('aams_id') }}/" + SectionId,
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
    {{-- /cust  --}}


    {{-- cust  --}}
    <script>
        $(document).ready(function() {
            $('select[name="ppms_id"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('ppms_id') }}/" + SectionId,
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
    {{-- /cust  --}}






{{-- <!-- تأكد من وجود عناصر الإدخال المناسبة في الصفحة -->
<input type="date" id="customer_po_date" name="customer_po_date" placeholder="أدخل التاريخ">
<input type="number" id="customer_po_duration" name="customer_po_duration" placeholder="أدخل عدد الأيام">
<input type="text" id="customer_po_deadline" name="customer_po_deadline" placeholder="تاريخ الإنتهاء" readonly> --}}

<script>
document.addEventListener("DOMContentLoaded", function() {
    // الحصول على عناصر الإدخال
    const dateInput = document.getElementById('customer_po_date');
    const durationInput = document.getElementById('customer_po_duration');
    const deadlineInput = document.getElementById('customer_po_deadline');

    // دالة لحساب تاريخ الإنتهاء
    function calculateDeadline() {
        const dateValue = dateInput.value; // يفترض أن يكون التاريخ بصيغة yyyy-mm-dd
        const duration = parseInt(durationInput.value, 10);

        if (dateValue && !isNaN(duration)) {
            // تحويل النص إلى كائن تاريخ
            const dateObj = new Date(dateValue);
            // إضافة عدد الأيام
            dateObj.setDate(dateObj.getDate() + duration);

            // تنسيق التاريخ الناتج بصيغة yyyy-mm-dd
            const dd = String(dateObj.getDate()).padStart(2, '0');
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0'); // الأشهر تبدأ من 0
            const yyyy = dateObj.getFullYear();
            const formattedDate = `${yyyy}-${mm}-${dd}`;

            // عرض التاريخ المحسوب في حقل deadline
            deadlineInput.value = formattedDate;
        } else {
            deadlineInput.value = '';
        }
    }

    // إضافة الأحداث لتحديث التاريخ عند تغيير أي من الحقول
    dateInput.addEventListener('change', calculateDeadline);
    durationInput.addEventListener('input', calculateDeadline);
});
</script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
@endsection
