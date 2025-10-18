@extends('layouts.master')
@section('title')
    PMs | MDSJEDPR
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
        .alert { animation: slideIn 0.3s ease-out; }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .table tbody tr { transition: background-color 0.2s ease; }
        .table tbody tr:hover { background-color: rgba(0, 123, 255, 0.05); }
        .btn { transition: all 0.2s ease; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }

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
            #pm-details-content, #pm-details-content * { visibility: visible; }
            #pm-details-content { position: absolute; left: 0; top: 0; width: 100%; }
            .btn-group { display: none !important; }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Project Managers</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ All PMs</span>
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
    @if (session()->has('Error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Error') }}</strong>
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
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="card-title mb-0">Project Managers</h5>
                            <small class="text-muted">Manage and view all PM information</small>
                        </div>
                   <div class="d-flex justify-content-between align-items-center flex-wrap">

    <div class="d-flex align-items-center">

        <!-- Export Buttons -->
        <button onclick="exportToPDF()" class="btn btn-sm btn-danger btn-export-pdf mr-1">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button onclick="exportToExcel()" class="btn btn-sm btn-success btn-export-excel mr-1">
            <i class="fas fa-file-excel"></i> Excel
        </button>
        <button onclick="exportToCSV()" class="btn btn-sm btn-info btn-export-csv mr-1">
            <i class="fas fa-file-csv"></i> CSV
        </button>
        <button onclick="printTable()" class="btn btn-sm btn-secondary btn-export-print mr-2">
            <i class="fas fa-print"></i> Print
        </button>

        @can('Add')
        <a class="btn btn-primary modal-effect" data-effect="effect-scale" data-toggle="modal"
            href="#modaldemo8">
            <i class="fas fa-plus"></i> Add PM
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
                                    <th>PM Name </th>
                                    <th>PM Email </th>
                                    <th>PM Phone</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($ppms as $index => $x)
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
                                            <p>No PMs found</p>
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
                    <h6 class="modal-title"> Add PM </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pm.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">PM Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter PM name" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="email">PM Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter PM email" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="phone">PM Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="Enter PM phone" required autocomplete="off">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save"></i> Add PM
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="las la-times"></i> Cancel
                            </button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit PM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="pm/update" method="post" autocomplete="off">
                        {{ method_field('put') }}
                        {{ csrf_field() }}



                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label for="name" class="col-form-label">PM Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" id="name" type="text" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">PM Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-form-label">PM Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" required autocomplete="off">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="las la-check"></i> Update PM
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="las la-times"></i> Cancel
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient">
                    <h5 class="modal-title text-white" id="viewModalLabel">
                        <i class="las la-user-circle"></i> PM Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pm-details-content">
                    <!-- Export Buttons -->
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-sm btn-secondary mr-1" onclick="printPM()" title="Print PM Details">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-success mr-1" onclick="exportPMToExcel()" title="Export to Excel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-info mr-2" onclick="exportPMToCSV()" title="Export to CSV">
                            <i class="fas fa-file-csv"></i> CSV
                        </button>
                    </div>

                    <!-- PM Information Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="view-name" class="col-form-label font-weight-bold">
                                            <i class="las la-user text-primary"></i> PM Name
                                        </label>
                                        <input class="form-control" id="view-name" type="text" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="view-email" class="col-form-label font-weight-bold">
                                            <i class="las la-envelope text-primary"></i> PM Email
                                        </label>
                                        <input type="email" class="form-control" id="view-email" readonly>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="view-phone" class="col-form-label font-weight-bold">
                                            <i class="las la-phone text-primary"></i> PM Phone
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

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="pm/destroy" method="post">
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
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $(function() {
            // Initialize DataTable
            var table = $('#example1').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false
            });


            // View modal handler
            $('#viewModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const modal = $(this);
                modal.find('#view-name').val(button.data('name'));
                modal.find('#view-email').val(button.data('email'));
                modal.find('#view-phone').val(button.data('phone'));
            });

            // Edit modal handler
            $('#exampleModal2').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const modal = $(this);
                modal.find('.modal-body #id').val(button.data('id'));
                modal.find('.modal-body #name').val(button.data('name'));
                modal.find('.modal-body #email').val(button.data('email'));
                modal.find('.modal-body #phone').val(button.data('phone'));
            });

            // Delete modal handler
            $('#modaldemo9').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const modal = $(this);
                modal.find('.modal-body #id').val(button.data('id'));
                modal.find('.modal-body #name').val(button.data('name'));
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Add loading state to form submission buttons
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            });
        });

        // --- Functions for actions inside the View Modal ---

        function printPM() {
            const button = event.target.closest('button');
            showLoadingButton(button);
            try {
                const pmName = document.getElementById('view-name').value;
                const pmEmail = document.getElementById('view-email').value;
                const pmPhone = document.getElementById('view-phone').value;
                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html><html><head><title>PM Details - ${pmName}</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <style>
                        body { font-family: 'Segoe UI', sans-serif; margin: 20px; background-color: #f4f7f6; }
                        .container { max-width: 700px; margin: auto; background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
                        .header { text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 20px; margin-bottom: 30px; }
                        .header h1 { margin: 0; color: #667eea; font-size: 2.2em; }
                        .detail-item { display: flex; align-items: center; background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 5px solid #764ba2; margin-bottom: 15px; }
                        .detail-item i { font-size: 24px; color: #764ba2; margin-right: 15px; width: 30px; text-align: center; }
                        .detail-content .label { font-size: 0.9em; color: #888; margin-bottom: 3px; }
                        .detail-content .value { font-size: 1.1em; color: #333; font-weight: 500; }
                        .footer { margin-top: 40px; text-align: center; font-size: 0.8em; color: #aaa; border-top: 1px solid #eee; padding-top: 20px; }
                        @media print { body { background-color: #fff; } .container { box-shadow: none; border: 1px solid #ccc; } }
                    </style></head><body>
                    <div class="container">
                        <div class="header"><h1>Project Manager Details</h1></div>
                        <div class="details-grid">
                            <div class="detail-item"><i class="fas fa-user"></i><div class="detail-content"><div class="label">Name</div><div class="value">${pmName}</div></div></div>
                            <div class="detail-item"><i class="fas fa-envelope"></i><div class="detail-content"><div class="label">Email</div><div class="value">${pmEmail}</div></div></div>
                            <div class="detail-item"><i class="fas fa-phone"></i><div class="detail-content"><div class="label">Phone</div><div class="value">${pmPhone}</div></div></div>
                        </div>
                        <div class="footer"><p>Report generated on: ${new Date().toLocaleString()}</p><p>MDSJEDPR - Management System</p></div>
                    </div></body></html>`;
                printWindow.document.write(printContent);
                printWindow.document.close();
                setTimeout(() => { printWindow.print(); hideLoadingButton(button); }, 500);
            } catch (e) {
                console.error("Print Error:", e);
                hideLoadingButton(button);
                showErrorToast('Could not generate print view.');
            }
        }

        function exportPMToExcel() {
            const button = event.target.closest('button');
            showLoadingButton(button);
            try {
                const pmName = document.getElementById('view-name').value;
                const data = [
                    ['Field', 'Value'],
                    ['PM Name', pmName],
                    ['PM Email', document.getElementById('view-email').value],
                    ['PM Phone', document.getElementById('view-phone').value]
                ];
                const csvContent = "data:text/csv;charset=utf-8," + data.map(e => e.join(",")).join("\n");
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", `PM_${pmName.replace(/\s+/g, '_')}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                showSuccessToast('File exported successfully!');
            } catch (e) {
                console.error("Export Error:", e);
                showErrorToast('Export failed.');
            } finally {
                hideLoadingButton(button);
            }
        }

        function exportPMToCSV() {
            exportPMToExcel(); // They perform the same function of creating a CSV
        }

        // --- Helper Functions ---

        function showLoadingButton(button) {
            if (!button) return;
            button.classList.add('btn-loading');
            const icon = button.querySelector('i');
            if (icon) {
                icon.dataset.originalIcon = icon.className;
                icon.className = 'fas fa-spinner fa-spin';
            }
        }

        function hideLoadingButton(button) {
            if (!button) return;
            button.classList.remove('btn-loading');
            const icon = button.querySelector('i');
            if (icon && icon.dataset.originalIcon) {
                icon.className = icon.dataset.originalIcon;
            }
        }

        function showSuccessToast(message) {
            showToast(message, 'alert-success', '<i class="fas fa-check-circle"></i> Success!');
        }

        function showErrorToast(message) {
            showToast(message, 'alert-danger', '<i class="fas fa-exclamation-circle"></i> Error!');
        }

        function showToast(message, type, title) {
            const toast = document.createElement('div');
            toast.className = `alert ${type} position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px; animation: slideIn 0.3s ease-out;';
            toast.innerHTML = `<strong>${title}</strong><p class="mb-0">${message}</p>`;
            document.body.appendChild(toast);
            setTimeout(() => {
                const fadeOutKeyframes = [{ opacity: 1 }, { opacity: 0 }];
                const fadeOutOptions = { duration: 500, easing: 'ease-in' };
                toast.animate(fadeOutKeyframes, fadeOutOptions).onfinish = () => toast.remove();
            }, 4000);
        }
    </script>

    <!-- Unified Export Functions -->
    <script src="{{ URL::asset('assets/js/export-functions.js') }}"></script>
@endsection
