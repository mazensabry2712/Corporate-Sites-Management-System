@extends('layouts.master')
@section('title')
    AMs
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

        /* تحسين شكل الـ Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px 20px;
            position: relative;
            animation: slideInDown 0.5s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            color: white;
        }

        .alert .close {
            color: white;
            opacity: 0.8;
            font-size: 20px;
        }

        .alert .close:hover {
            opacity: 1;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* تأكيد عدم الاختفاء السريع */
        .alert.fade.show {
            opacity: 1 !important;
        }

        /* View Modal Styles */
        .bg-primary-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .modal-lg {
            max-width: 800px;
        }
        
        #viewModal .card {
            border-radius: 10px;
        }
        
        #viewModal .form-control[readonly] {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            cursor: default;
        }
        
        #viewModal label {
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        /* Export buttons animation */
        .btn-group .btn {
            transition: all 0.3s ease;
        }
        
        .btn-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        /* Loading animation */
        .btn-loading {
            pointer-events: none;
            opacity: 0.6;
        }
        
        .btn-loading .fas {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Print styles */
        @media print {
            body * { visibility: hidden; }
            #am-details-content, #am-details-content * { visibility: visible; }
            #am-details-content { position: absolute; left: 0; top: 0; width: 100%; }
            .btn-group { display: none !important; }
        }
    </style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    AMs</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show"
            role="alert" style="position: relative; z-index: 1050;">
            <div class="d-flex align-items-center">
                <i class="fas fa-plus mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Added!</strong>
                    <div>{{ session()->get('Add') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 15px; right: 20px;">
                <span aria-hidden="true" style="color: white; font-size: 24px;">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show"
            role="alert" style="position: relative; z-index: 1050;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Error!</strong>
                    <div>{{ session()->get('Error') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 15px; right: 20px;">
                <span aria-hidden="true" style="color: white; font-size: 24px;">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show"
            role="alert" style="position: relative; z-index: 1050;">
            <div class="d-flex align-items-center">
                <i class="fas fa-trash mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Deleted!</strong>
                    <div>{{ session()->get('delete') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 15px; right: 20px;">
                <span aria-hidden="true" style="color: white; font-size: 24px;">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show"
            role="alert" style="position: relative; z-index: 1050;">
            <div class="d-flex align-items-center">
                <i class="fas fa-edit mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Updated!</strong>
                    <div>{{ session()->get('edit') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 15px; right: 20px;">
                <span aria-hidden="true" style="color: white; font-size: 24px;">&times;</span>
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
                            <h6 class="card-title mb-0">Account Managers Management</h6>
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
                                    <a class="btn btn-primary" data-effect="effect-scale" data-toggle="modal"
                                        href="#modaldemo8">
                                        <i class="fas fa-plus"></i> Add Account Manager
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
                                    <th>Operations</th>
                                    <th>AM Name</th>
                                    <th>AM Email</th>
                                    <th>AM Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aams as $index => $x)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a class="modal-effect btn btn-sm btn-primary" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                data-email="{{ $x->email }}" data-phone="{{ $x->phone }}"
                                                data-toggle="modal" href="#viewModal" title="View">
                                                <i class="las la-eye"></i>
                                            </a>

                                            @can('Edit')
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                data-email="{{ $x->email }}" data-phone="{{ $x->phone }}"
                                                data-toggle="modal" href="#exampleModal2" title="Update">
                                                <i class="las la-pen"></i>
                                            </a>
                                            @endcan

                                            @can('Delete')
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                data-toggle="modal" href="#modaldemo9" title="Delete">
                                                <i class="las la-trash"></i>
                                            </a>
                                            @endcan
                                        </td>
                                        <td>{{ $x->name }}</td>
                                        <td>{{ $x->email }}</td>
                                        <td>{{ $x->phone }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="las la-inbox" style="font-size: 48px;"></i>
                                            <p>No AMs found</p>
                                        </td>
                                    </tr>
                                @endforelse
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
                    <h6 class="modal-title"> Add AM </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('am.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">AM Name</label>
                            <input type="text" class="form-control" id="name" name="name" {{--  placeholder="Enter AM name" --}}
                                required>
                        </div>

                        <div class="form-group">
                            <label for="email">AM Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                {{--  placeholder="Enter AM email" --}}required>
                        </div>

                        <div class="form-group">
                            <label for="phone">AM Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                {{--  placeholder="Enter AM phone number"   pattern="[0-9]{10}" --}}required>
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


    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient">
                    <h5 class="modal-title text-white" id="viewModalLabel">
                        <i class="las la-user-circle"></i> AM Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="am-details-content">
                    <!-- Export Buttons -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group" role="group" aria-label="Export Options">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="printAM()" title="Print AM Details">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="exportAMToExcel()" title="Export to Excel">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="exportAMToCSV()" title="Export to CSV">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </div>
                    </div>

                    <!-- AM Information Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="view-name" class="col-form-label font-weight-bold">
                                            <i class="las la-user text-primary"></i> AM Name
                                        </label>
                                        <input class="form-control" id="view-name" type="text" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="view-email" class="col-form-label font-weight-bold">
                                            <i class="las la-envelope text-primary"></i> AM Email
                                        </label>
                                        <input type="email" class="form-control" id="view-email" readonly>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="view-phone" class="col-form-label font-weight-bold">
                                            <i class="las la-phone text-primary"></i> AM Phone
                                        </label>
                                        <input type="tel" class="form-control" id="view-phone" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="las la-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit AM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="am/update" method="post" autocomplete="off">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}



                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="recipient-name" class="col-form-label">AM Name</label>
                            <input class="form-control" name="name" id="name" type="text">
                        </div>





                        <div class="form-group">
                            <label for="message-text" class="col-form-label">AM Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">AM Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
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
                <form action="am/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
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
        // View modal
        $('#viewModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const modal = $(this);

            modal.find('#view-name').val(button.data('name'));
            modal.find('#view-email').val(button.data('email'));
            modal.find('#view-phone').val(button.data('phone'));
        });

        // Edit modal
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var email = button.data('email')
            var phone = button.data('phone')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #phone').val(phone);
        })
    </script>

    <script>
        // Delete modal
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var email = button.data('email')
            var phone = button.data('phone')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #phone').val(phone);
        })

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    <!-- Export Functions -->
    <script>
        // Export to PDF
        function exportToPDF() {
            $('#example1').DataTable().button('.buttons-pdf').trigger();
        }

        // Export to Excel
        function exportToExcel() {
            $('#example1').DataTable().button('.buttons-excel').trigger();
        }

        // Export to CSV
        function exportToCSV() {
            $('#example1').DataTable().button('.buttons-csv').trigger();
        }

        // Print Table
        function printTable() {
            $('#example1').DataTable().button('.buttons-print').trigger();
        }

        // Print AM Function
        function printAM() {
            const button = event.target.closest('button');
            showLoadingButton(button);

            try {
                const amName = document.getElementById('view-name').value;
                const amEmail = document.getElementById('view-email').value;
                const amPhone = document.getElementById('view-phone').value;

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>AM Details - ${amName}</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                            .header { text-align: center; margin-bottom: 40px; border-bottom: 3px solid #667eea; padding-bottom: 20px; }
                            .header h1 { color: #667eea; margin: 0; font-size: 28px; }
                            .header p { color: #666; margin: 10px 0 0 0; }
                            .am-details { margin: 30px 0; background: #f8f9fa; padding: 30px; border-radius: 10px; }
                            .detail-row { display: flex; margin: 20px 0; padding: 15px; background: white; border-radius: 5px; border-left: 4px solid #667eea; }
                            .detail-label { font-weight: bold; width: 150px; color: #495057; }
                            .detail-value { flex: 1; color: #212529; }
                            .footer { margin-top: 50px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
                            @media print {
                                body { margin: 20px; }
                                .no-print { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <h1>Account Manager Details</h1>
                            <p>Generated on: ${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                        </div>
                        <div class="am-details">
                            <div class="detail-row">
                                <div class="detail-label">👤 Name:</div>
                                <div class="detail-value">${amName}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">📧 Email:</div>
                                <div class="detail-value">${amEmail}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">📱 Phone:</div>
                                <div class="detail-value">${amPhone}</div>
                            </div>
                        </div>
                        <div class="footer">
                            <p>Corporate Sites Management System - AM Report</p>
                            <p>This is an automatically generated document</p>
                        </div>
                    </body>
                    </html>
                `;

                printWindow.document.write(printContent);
                printWindow.document.close();

                setTimeout(() => {
                    printWindow.print();
                    hideLoadingButton(button);
                }, 500);

                showSuccessToast('Print dialog opened!');
            } catch (error) {
                console.error('Print error:', error);
                window.print();
                hideLoadingButton(button);
                showSuccessToast('Browser print opened as alternative!');
            }
        }

        // Export AM to Excel Function
        function exportAMToExcel() {
            const button = event.target.closest('button');
            showLoadingButton(button);

            try {
                const amName = document.getElementById('view-name').value;
                const amEmail = document.getElementById('view-email').value;
                const amPhone = document.getElementById('view-phone').value;

                const data = [
                    ['Field', 'Value'],
                    ['AM Name', amName],
                    ['AM Email', amEmail],
                    ['AM Phone', amPhone],
                    ['', ''],
                    ['Generated On', new Date().toLocaleString()]
                ];

                const csv = data.map(row => row.join(',')).join('\n');
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                
                link.setAttribute('href', url);
                link.setAttribute('download', `AM_${amName.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                hideLoadingButton(button);
                showSuccessToast('Excel file exported successfully!');
            } catch (error) {
                console.error('Excel export error:', error);
                hideLoadingButton(button);
                showSuccessToast('Export failed. Please try again.');
            }
        }

        // Export AM to CSV Function
        function exportAMToCSV() {
            exportAMToExcel(); // Same functionality
        }

        // Helper Functions
        function showLoadingButton(button) {
            button.classList.add('btn-loading');
            const icon = button.querySelector('i');
            if (icon) icon.classList.add('fa-spin');
        }

        function hideLoadingButton(button) {
            button.classList.remove('btn-loading');
            const icon = button.querySelector('i');
            if (icon) icon.classList.remove('fa-spin');
        }

        function showSuccessToast(message) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-success position-fixed';
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px; animation: slideIn 0.3s ease-out;';
            toast.innerHTML = `
                <strong><i class="fas fa-check-circle"></i> Success!</strong>
                <p class="mb-0">${message}</p>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
@endsection
