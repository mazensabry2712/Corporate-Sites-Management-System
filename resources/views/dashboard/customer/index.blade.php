@extends('layouts.master')
@section('title')
    Customers | MDSJEDPR
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <style>
        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            transition: 0.3s;
        }
        .img-thumbnail:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .no-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 50px;
            width: 50px;
            border: 1px dashed #ccc;
            border-radius: 4px;
        }

        /* Hide default DataTables buttons */
        .dt-buttons {
            display: none !important;
        }

        /* Export buttons styling */
        .export-buttons .btn {
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .export-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }

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

        /* Force table to stay in single row */
        #example1 {
            white-space: nowrap;
        }

        #example1 td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        #example1 th {
            white-space: nowrap;
        }

        /* Responsive table settings */
        .table-responsive {
            overflow-x: auto;
        }

        /* Prevent responsive breaking */
        .dt-responsive {
            width: 100% !important;
        }

        /* Make sure DataTable doesn't break columns */
        .dataTable {
            width: 100% !important;
        }
    </style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Customers</span>
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











    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">


                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-0">Customers Management</h5>
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
                            <a class="btn btn-primary" href="{{ route('customer.create') }}">
                                <i class="fas fa-plus"></i> Add Customer
                            </a>
                            @endcan
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
                                    <th>Customer Name </th>
                                    <th>Customer Abb </th>
                                    <th>Customer type </th>
                                    <th> Logo </th>
                                    <th> Customer Contact name </th>
                                    <th> Customer contact position </th>
                                    <th>Email </th>
                                    <th>Phone</th>

                                </tr>

                            </thead>

                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($custs as $cust)
                                    <?php $i++; ?>

                                    <td>{{ $i }}</td>
                                    <td>
                                        {{-- @can('View') --}}
                                        <a href="{{ route('customer.show', $cust->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                            <i class="las la-eye"></i>
                                        </a>
                                        {{-- @endcan --}}
                                        @can('Edit')
                                        <a href="{{ route('customer.edit', $cust->id) }}" class="btn btn-sm btn-info" title="Edit">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('Delete')
                                        <a class="btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $cust->id }}" data-name="{{ $cust->name }}"
                                            data-toggle="modal" href="#modaldemo9" title="Delete">
                                            <i class="las la-trash"></i>
                                        </a>
                                        @endcan
                                    </td>
                                    <td>{{ $cust->name }}</td>
                                    <td>{{ $cust->abb }}</td>
                                    <td>{{ $cust->tybe }}</td>
                                    {{-- <td>{{ $cust->custs_attachments->logo }}</td> --}}
                                    {{-- <td>{{ $cust->logo }}</td> --}}
                                    <td>
                                        @if($cust->logo && file_exists(public_path($cust->logo)))
                                            <a href="{{ asset($cust->logo) }}" data-lightbox="gallery-{{$cust->id}}"
                                                data-title="{{$cust->name}} Logo" title="Click to view full size">
                                                <img src="{{ asset($cust->logo) }}" alt="{{$cust->name}} Logo"
                                                     height="50" width="50" class="img-thumbnail"
                                                     title="{{$cust->name}} Logo - Click to enlarge">
                                            </a>
                                        @else
                                            <div class="no-image" title="No logo uploaded">
                                                <i class="fas fa-building text-muted" style="font-size: 20px;"></i>
                                                <small class="text-muted" style="font-size: 10px;">No Logo</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $cust->customercontactname }}</td>
                                    <td>{{ $cust->customercontactposition }}</td>
                                    <td>{{ $cust->email }}</td>
                                    <td>{{ $cust->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

                <form id="deleteForm" action="" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
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

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        // إعداد Lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "صورة %1 من %2"
        });

        // Initialize DataTable with export buttons
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm d-none',
                        title: 'Customers Report',
                        exportOptions: {
                            columns: ':not(:first-child):not(:nth-child(2))'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm d-none',
                        title: 'Customers Report',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':not(:first-child):not(:nth-child(2))'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-info btn-sm d-none',
                        title: 'Customers Report',
                        exportOptions: {
                            columns: ':not(:first-child):not(:nth-child(2))'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-warning btn-sm d-none',
                        title: 'Customers Report',
                        exportOptions: {
                            columns: ':not(:first-child):not(:nth-child(2))'
                        }
                    }
                ],
                responsive: false, // Disable responsive to keep single row
                lengthChange: false,
                autoWidth: false,
                scrollX: true, // Enable horizontal scrolling
                scrollCollapse: true,
                columnDefs: [
                    { width: "5%", targets: 0 }, // #
                    { width: "15%", targets: 1 }, // Actions
                    { width: "20%", targets: 2 }, // Name
                    { width: "10%", targets: 3 }, // Abbreviation
                    { width: "10%", targets: 4 }, // Type
                    { width: "10%", targets: 5 }, // Logo
                    { width: "15%", targets: 6 }, // Contact Name
                    { width: "15%", targets: 7 }, // Contact Position
                    { width: "15%", targets: 8 }, // Email
                    { width: "10%", targets: 9 }  // Phone
                ]
            });
        });

        // Export Functions with loading feedback
        function exportToPDF() {
            showLoadingButton('PDF');
            try {
                $('#example1').DataTable().button('.buttons-pdf').trigger();
                showSuccessMessage('PDF export started successfully!');
            } catch (error) {
                console.error('PDF export error:', error);
                printCustomersTable(); // Fallback to manual print
                showSuccessMessage('Alternative print method used!');
            }
            resetButton();
        }

        function exportToExcel() {
            showLoadingButton('Excel');
            try {
                $('#example1').DataTable().button('.buttons-excel').trigger();
                showSuccessMessage('Excel file is being generated!');
            } catch (error) {
                console.error('Excel export error:', error);
                downloadTableAsCSV(); // Fallback to CSV
                showSuccessMessage('CSV file downloaded as alternative!');
            }
            resetButton();
        }

        function exportToCSV() {
            showLoadingButton('CSV');
            try {
                $('#example1').DataTable().button('.buttons-csv').trigger();
                showSuccessMessage('CSV file is being generated!');
            } catch (error) {
                console.error('CSV export error:', error);
                downloadTableAsCSV(); // Fallback to manual CSV
                showSuccessMessage('CSV file downloaded successfully!');
            }
            resetButton();
        }

        function printTable() {
            showLoadingButton('Print');
            try {
                $('#example1').DataTable().button('.buttons-print').trigger();
                showSuccessMessage('Print dialog opened!');
            } catch (error) {
                console.error('Print error:', error);
                printCustomersTable(); // Fallback to manual print
                showSuccessMessage('Print window opened!');
            }
            resetButton();
        }

        // Helper functions for user feedback
        function showLoadingButton(type) {
            const buttons = document.querySelectorAll('.btn-group .btn');
            buttons.forEach(btn => {
                if (btn.textContent.includes(type)) {
                    btn.classList.add('btn-loading');
                    const icon = btn.querySelector('i');
                    if (icon) {
                        icon.classList.add('fa-spin');
                    }
                }
            });
        }

        function resetButton() {
            setTimeout(() => {
                const buttons = document.querySelectorAll('.btn-group .btn');
                buttons.forEach(btn => {
                    btn.classList.remove('btn-loading');
                    const icon = btn.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-spin');
                    }
                });
            }, 2000);
        }

        function showSuccessMessage(message) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-success position-fixed';
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <i class="fas fa-check-circle mr-2"></i>
                ${message}
                <button type="button" class="close ml-2" onclick="this.parentElement.remove()">
                    <span>&times;</span>
                </button>
            `;
            document.body.appendChild(toast);

            // Auto remove after 4 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 4000);
        }

        // Alternative manual export functions as backup
        function downloadTableAsCSV() {
            const table = document.getElementById('example1');
            let csv = [];
            const rows = table.querySelectorAll('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll('td, th');

                for (let j = 2; j < cols.length; j++) { // Skip first two columns (# and Actions)
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
                    data = data.replace(/"/g, '""');
                    row.push('"' + data + '"');
                }
                csv.push(row.join(','));
            }

            const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
            const downloadLink = document.createElement('a');
            downloadLink.download = 'customers_' + new Date().toISOString().slice(0, 10) + '.csv';
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        function printCustomersTable() {
            const printWindow = window.open('', '_blank');
            const table = document.getElementById('example1').cloneNode(true);

            // Remove action columns
            const actionCells = table.querySelectorAll('td:first-child, th:first-child, td:nth-child(2), th:nth-child(2)');
            actionCells.forEach(cell => cell.remove());

            const printContent = `
                <html>
                <head>
                    <title>Customers Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { border-collapse: collapse; width: 100%; font-size: 12px; }
                        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
                        th { background-color: #f2f2f2; font-weight: bold; }
                        .header { text-align: center; margin-bottom: 20px; }
                        @media print {
                            body { margin: 0; }
                            table { page-break-inside: auto; }
                            tr { page-break-inside: avoid; page-break-after: auto; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>Customers Report</h2>
                        <p>Generated on: ${new Date().toLocaleDateString()}</p>
                    </div>
                    ${table.outerHTML}
                </body>
                </html>
            `;

            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <!-- <script src="{{ URL::asset('assets/js/table-data.js') }}"></script> --> <!-- Removed to avoid DataTable reinitialize conflict -->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>



    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var abb = button.data('abb');
            var tybe = button.data('tybe');
            var logo = button.data('logo');
            var customercontactname = button.data('customercontactname');
            var customercontactposition = button.data('customercontactposition');
            var email = button.data('email');
            var phone = button.data('phone');
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #abb').val(abb);
            modal.find('.modal-body #tybe').val(tybe);
            modal.find('.modal-body #logo').val(logo);
            modal.find('.modal-body #customercontactname').val(customercontactname);
            modal.find('.modal-body #customercontactposition').val(customercontactposition);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #abb').val(abb);

        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var name = button.data('name');
            var modal = $(this);

            // Update form action URL with the customer ID for delete route
            modal.find('form').attr('action', '{{ route("customer.destroy", ":id") }}'.replace(':id', id));
            modal.find('.modal-body #name').val(name);
        });
    </script>

    <!-- Export Functions -->
    <script src="{{ URL::asset('assets/js/export-functions.js') }}"></script>
@endsection
