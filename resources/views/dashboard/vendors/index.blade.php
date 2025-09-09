@extends('layouts.master')
@section('title')
    Vendors
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
        /* تحسين شكل عرض vendor AM details */
        .vendor-am-details {
            max-width: 300px !important;
            min-width: 200px;
            white-space: normal !important;
        }

        .vendor-am-details .text-wrap {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #007bff;
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
        #example1 td.vendor-am-details {
            padding: 10px 8px;
            vertical-align: top;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .vendor-am-details {
                max-width: 250px !important;
            }

            .vendor-am-details .text-wrap {
                font-size: 12px;
                padding: 6px 8px;
            }
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
                    Vendors</span>
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
    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Vendors Management</h6>
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
                                        <i class="fas fa-plus"></i> Add Vendor
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
                                    <th>Vendors </th>
                                    <th>Vendor AM details </th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($vendors as $vendor)
                                    <?php $i++; ?>

                                    <td>{{ $i }}</td>
                                    <td>
                                        @can('Edit')
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $vendor->id }}" data-vendors="{{ $vendor->vendors }}"
                                                data-vendor_am_details="{{ $vendor->vendor_am_details }}" data-toggle="modal"
                                                href="#exampleModal2" title="Upadte"><i class="las la-pen"></i></a>
                                        @endcan

                                        @can('Delete')
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $vendor->id }}" data-vendors="{{ $vendor->vendors }}"
                                                data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                    class="las la-trash"></i></a>
                                        @endcan
                                    </td>

                                    <td>{{ $vendor->vendors }}</td>
                                    <td class="vendor-am-details">
                                        <div class="text-wrap">
                                            {{ $vendor->vendor_am_details }}
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
                    <h6 class="modal-title"> Add Vendor </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vendors.store') }}" method="post">
                        {{-- <form action="vendors/store" method="post"> --}}
                        @csrf


                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1"> AM name </label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">AM email </label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> AM phone </label>
                            <input type="number" class="form-control" id="phone" name="phone">
                        </div> --}}
                        <div class="form-group">
                            <label for="vendors">Vendors</label>
                            <input type="text" class="form-control" id="vendors" name="vendors" required>
                        </div>
                        <div class="form-group">
                            <label for="vendor_am_details">Vendor AM Details</label>
                            <textarea class="form-control" id="vendor_am_details" name="vendor_am_details"
                                rows="4" placeholder="Enter vendor account manager details..." required></textarea>
                        </div>





                        {{-- <div class="form-group">
                            <label for="exampleFormControlTextarea1">Project Name</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div> --}}

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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- @foreach ($vendors as $vendor)
                        <form action="{{ route('vendors.update', $vendor->id) }}" method="POST" autocomplete="off">
                            @endforeach --}}
                    <form action="vendors/update" method="POST" autocomplete="off">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="vendors" class="col-form-label">Vendor</label>
                            <input class="form-control" name="vendors" id="vendors" type="text">
                        </div>

                        <div class="form-group">
                            <label for="vendor_am_details" class="col-form-label">Vendor AM Details</label>
                            <textarea class="form-control" name="vendor_am_details" id="vendor_am_details"
                                rows="4" placeholder="Enter vendor account manager details..."></textarea>
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
                {{-- @foreach ($vendors as $vendor)
                    <form action="{{ route('vendors.destroy', $vendor->id) }}" method="post">
                        @csrf
                        @endforeach --}}
                <form action="vendors/destroy" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="vendors" id="vendors" type="text" readonly>
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
            var vendors = button.data('vendors')
            var vendor_am_details = button.data('vendor_am_details')

            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #vendors').val(vendors);
            modal.find('.modal-body #vendor_am_details').val(vendor_am_details);

        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var vendors = button.data('vendors')
            var vendor_am_details = button.data('vendor_am_details')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #vendors').val(vendors);
            modal.find('.modal-body #vendor_am_details').val(vendor_am_details);

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
                        title: 'Vendors List'
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'buttons-excel d-none',
                        title: 'Vendors List'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'buttons-csv d-none',
                        title: 'Vendors List'
                    },
                    {
                        extend: 'print',
                        className: 'buttons-print d-none',
                        title: 'Vendors List'
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
