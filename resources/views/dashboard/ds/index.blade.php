@extends('layouts.master')
@section('title')
Disti/ Supplier
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <style>
        /* تحسين شكل عرض DS details */
        .ds-details {
            max-width: 300px !important;
            min-width: 200px;
            white-space: normal !important;
        }

        .ds-details .text-wrap {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #dc3545;
            font-size: 13px;
            line-height: 1.6;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-height: 120px;
            overflow-y: auto;
        }

        /* تحسين شكل الجدول */
        #example1 {
            width: 100% !important;
            table-layout: auto;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        /* تحسين العمود */
        #example1 td.ds-details {
            padding: 10px 8px;
            vertical-align: top;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .ds-details {
                max-width: 250px !important;
            }

            .ds-details .text-wrap {
                font-size: 12px;
                padding: 6px 8px;
            }
        }

        /* تحسين مظهر textarea في الـ modals */
        .modal-body textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-body textarea:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        /* تحسين أزرار التصدير */
        .export-buttons .btn {
            transition: all 0.3s ease;
            margin: 0 1px;
            border-radius: 4px;
        }

        .export-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        /* إخفاء أزرار DataTables الافتراضية */
        .dt-buttons {
            display: none !important;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .btn-group {
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Disti/ Supplier </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
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



    @php
    $alerts = [
        'Add' => 'success',
        'Error' => 'danger',
        'delete' => 'danger',
        'edit' => 'success',
    ];
@endphp

@foreach ($alerts as $key => $type)
    @if (session()->has($key))
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            <strong>{{ session()->get($key) }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach



    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Delivery Specialists Management</h6>
                        </div>
                        <div>
                            <div class="d-flex align-items-center">
                                <!-- Export buttons -->
                                <div class="btn-group export-buttons mr-2" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="exportToPDF()" title="Export to PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="exportToExcel()" title="Export to Excel">
                                        <i class="fas fa-file-excel"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info" onclick="exportToCSV()" title="Export to CSV">
                                        <i class="fas fa-file-csv"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="printTable()" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>

                                @can('Add')
                                    <a class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal"
                                        href="#modaldemo8">
                                        <i class="fas fa-plus"></i> Add Delivery Specialist
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Operations </th>
                                    <th>D/S Name </th>
                                    <th>D/S Contact Details </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($ds as $x)
                                    <?php $i++; ?>

                                    <td>{{ $i }}</td>
                                    <td>
                                        @can('Edit')
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                            data-id="{{ $x->id }}" data-dsname="{{ $x->dsname }}"
                                            data-ds_contact="{{ $x->ds_contact }}"
                                            data-toggle="modal" href="#exampleModal2" title="Upadte"><i
                                                class="las la-pen"></i></a>
                                        @endcan
                                        @can('Delete')
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $x->id }}" data-dsname="{{ $x->dsname }}"
                                            data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                class="las la-trash"></i></a>
                                        @endcan
                                    </td>
                                    <td>{{ $x->dsname }}</td>
                                    <td class="ds-details">
                                        <div class="text-wrap">
                                            {{ $x->ds_contact }}
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"> Add D/S </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ds.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="dsname">D/S Name </label>
                            <input type="text" class="form-control" id="dsname" name="dsname" >
                        </div>
                        <div class="form-group">
                            <label for="ds_contact">D/S Contact Details </label>
                            <textarea class="form-control" id="ds_contact" name="ds_contact" rows="4" placeholder="Enter delivery specialist contact details..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary">Add</button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->
        <!-- /row -->
    </div>






    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit D/S</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="ds/update" method="post" autocomplete="off">
                        {{ method_field('put') }}
                        {{ csrf_field() }}



                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="dsname" class="col-form-label">D/S Name</label>
                            <input class="form-control" name="dsname" id="dsname" type="text">
                        </div>
                        <div class="form-group">
                            <label for="ds_contact" class="col-form-label">D/S Contact Details</label>
                            <textarea class="form-control" name="ds_contact" id="ds_contact" rows="4" placeholder="Enter delivery specialist contact details..."></textarea>
                        </div>







                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">Confirm</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="ds/destroy" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="dsname" id="dsname" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
            </div>
            </form>
        </div>
    </div>








    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var dsname = button.data('dsname')
            var ds_contact = button.data('ds_contact')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #dsname').val(dsname);
            modal.find('.modal-body #ds_contact').val(ds_contact);
        })
    </script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var dsname = button.data('dsname')
            var ds_contact = button.data('ds_contact')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #dsname').val(dsname);
            modal.find('.modal-body #ds_contact').val(ds_contact);

        })
    </script>

    <script>
        // Export functions
        function exportToPDF() {
            const table = $('#example1').DataTable();
            table.button('.buttons-pdf').trigger();
        }

        function exportToExcel() {
            const table = $('#example1').DataTable();
            table.button('.buttons-excel').trigger();
        }

        function exportToCSV() {
            const table = $('#example1').DataTable();
            table.button('.buttons-csv').trigger();
        }

        function printTable() {
            const table = $('#example1').DataTable();
            table.button('.buttons-print').trigger();
        }

        // Enhanced DataTable initialization
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        className: 'buttons-pdf d-none',
                        title: 'Delivery Specialists List'
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'buttons-excel d-none',
                        title: 'Delivery Specialists List'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'buttons-csv d-none',
                        title: 'Delivery Specialists List'
                    },
                    {
                        extend: 'print',
                        className: 'buttons-print d-none',
                        title: 'Delivery Specialists List'
                    }
                ],
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
        });
    </script>
@endsection
