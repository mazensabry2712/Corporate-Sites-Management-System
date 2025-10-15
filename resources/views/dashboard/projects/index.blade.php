@extends('layouts.master')
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

        .attachment-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .attachment-icon {
            font-size: 24px;
            color: #007bff;
        }

        .attachment-name {
            font-size: 10px;
            text-align: center;
            word-break: break-all;
            max-width: 80px;
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Force table to stay in single row */
        #example1 {
            white-space: nowrap;
        }

        /* تحسين شكل عرض Description نفس استايل vendor AM details */
        .project-description {
            max-width: 300px !important;
            min-width: 200px;
            white-space: normal !important;
        }

        .project-description .text-wrap {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #28a745;
            font-size: 13px;
            line-height: 1.6;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-height: 120px;
            overflow-y: auto;
        }

        /* تحسين العمود */
        #example1 td.project-description {
            padding: 10px 8px;
            vertical-align: top;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .project-description {
                max-width: 250px !important;
            }

            .project-description .text-wrap {
                font-size: 12px;
                padding: 6px 8px;
            }
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
                <h4 class="content-title mb-0 my-auto">Dashboard</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Projects</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <!-- Additional header content can go here -->
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- Display success/error messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main content row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="card-title mb-0">Projects Management</h5>
                            <small class="text-muted">Manage and view all project information</small>
                        </div>
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

                            <!-- Add New Project Button -->
                            <a class="btn btn-primary" href="{{ route('projects.create') }}">
                                <i class="fas fa-plus"></i> Add New Project
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-bottom-0 text-center">#</th>
                                    <th class="border-bottom-0 text-center">Actions</th>
                                    <th class="border-bottom-0">PR Number</th>
                                    <th class="border-bottom-0">Project Name</th>
                                    <th class="border-bottom-0">Technologies</th>
                                    <th class="border-bottom-0">Primary Vendor</th>
                                    <th class="border-bottom-0">All Vendors</th>
                                    <th class="border-bottom-0">Primary DS</th>
                                    <th class="border-bottom-0">All DS</th>
                                    <th class="border-bottom-0">Primary Customer</th>
                                    <th class="border-bottom-0">All Customers</th>
                                    <th class="border-bottom-0">Customer PO</th>
                                    <th class="border-bottom-0 text-center">Value</th>
                                    <th class="border-bottom-0">AC Manager</th>
                                    <th class="border-bottom-0">Project Manager</th>
                                    <th class="border-bottom-0">Customer Contact</th>
                                    <th class="border-bottom-0 text-center">PO Attachment</th>
                                    <th class="border-bottom-0 text-center">EPO Attachment</th>
                                    <th class="border-bottom-0 text-center">PO Date</th>
                                    <th class="border-bottom-0 text-center">Duration (Days)</th>
                                    <th class="border-bottom-0 text-center">Deadline</th>
                                    <th class="border-bottom-0">Description</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($projects as $index => $project)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center action-buttons">
                                            <!-- View Project -->
                                            <a href="{{ route('projects.show', $project->id) }}"
                                                class="btn btn-sm btn-primary" title="View Details">
                                                <i class="las la-eye"></i>
                                            </a>

                                            @can('Edit')
                                                <a href="{{ route('projects.edit', $project->id) }}"
                                                    class="btn btn-sm btn-info" title="Edit">
                                                    <i class="las la-pen"></i>
                                                </a>
                                            @endcan

                                            @can('Delete')
                                                <a class="btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $project->id }}" data-name="{{ $project->name }}"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                        <td>
                                            @if ($project->pr_number)
                                                <span
                                                    class="badge badge-primary badge-custom">{{ $project->pr_number }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">{{ $project->name }}</td>
                                        <td>
                                            @if ($project->technologies)
                                                <span
                                                    class="badge badge-info badge-custom">{{ $project->technologies }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->vendor->vendors ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->vendors && $project->vendors->count() > 0)
                                                @foreach ($project->vendors as $vendor)
                                                    <span
                                                        class="badge badge-{{ $vendor->pivot->is_primary ? 'success' : 'secondary' }} badge-custom mr-1">
                                                        {{ $vendor->vendors }}
                                                        @if ($vendor->pivot->is_primary)
                                                            <i class="fas fa-star ml-1" title="Primary"></i>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->ds->dsname ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->deliverySpecialists && $project->deliverySpecialists->count() > 0)
                                                @foreach ($project->deliverySpecialists as $ds)
                                                    <span
                                                        class="badge badge-{{ $ds->pivot->is_lead ? 'success' : 'info' }} badge-custom mr-1">
                                                        {{ $ds->dsname }}
                                                        @if ($ds->pivot->is_lead)
                                                            <i class="fas fa-star ml-1" title="Lead DS"></i>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->cust->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->customers && $project->customers->count() > 0)
                                                @foreach ($project->customers as $customer)
                                                    <span
                                                        class="badge badge-{{ $customer->pivot->is_primary ? 'success' : 'warning' }} badge-custom mr-1">
                                                        {{ $customer->name }}
                                                        @if ($customer->pivot->is_primary)
                                                            <i class="fas fa-star ml-1" title="Primary"></i>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->customer_po ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            @if ($project->value)
                                                <span
                                                    class="badge badge-success badge-custom">${{ number_format($project->value, 2) }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->aams->name ?? 'N/A' }}</td>
                                        <td>{{ $project->ppms->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->customer_contact_details)
                                                <span title="{{ $project->customer_contact_details }}">
                                                    {{ Str::limit($project->customer_contact_details, 30) }}
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->po_attachment && file_exists(public_path($project->po_attachment)))
                                                @php
                                                    $fileExtension = strtolower(
                                                        pathinfo($project->po_attachment, PATHINFO_EXTENSION),
                                                    );
                                                    $isImage = in_array($fileExtension, [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif',
                                                        'webp',
                                                    ]);
                                                @endphp
                                                @if ($isImage)
                                                    <a href="{{ asset($project->po_attachment) }}"
                                                        data-lightbox="gallery-{{ $project->id }}"
                                                        data-title="PO Attachment - {{ $project->pr_number }}"
                                                        title="Click to view full size">
                                                        <img src="{{ asset($project->po_attachment) }}"
                                                            alt="PO Attachment" height="50" width="50"
                                                            class="img-thumbnail"
                                                            title="PO Attachment - Click to enlarge">
                                                    </a>
                                                @else
                                                    <div class="no-image" title="PO File Available">
                                                        <a href="{{ asset($project->po_attachment) }}" target="_blank"
                                                            title="Download PO File">
                                                            <i class="fas fa-file-alt text-primary"
                                                                style="font-size: 20px;"></i>
                                                            <small class="text-primary" style="font-size: 10px;">PO
                                                                File</small>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="no-image" title="No PO attachment uploaded">
                                                    <i class="fas fa-file-alt text-muted" style="font-size: 20px;"></i>
                                                    <small class="text-muted" style="font-size: 10px;">No PO</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->epo_attachment && file_exists(public_path($project->epo_attachment)))
                                                @php
                                                    $fileExtension = strtolower(
                                                        pathinfo($project->epo_attachment, PATHINFO_EXTENSION),
                                                    );
                                                    $isImage = in_array($fileExtension, [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif',
                                                        'webp',
                                                    ]);
                                                @endphp
                                                @if ($isImage)
                                                    <a href="{{ asset($project->epo_attachment) }}"
                                                        data-lightbox="gallery-{{ $project->id }}"
                                                        data-title="EPO Attachment - {{ $project->pr_number }}"
                                                        title="Click to view full size">
                                                        <img src="{{ asset($project->epo_attachment) }}"
                                                            alt="EPO Attachment" height="50" width="50"
                                                            class="img-thumbnail"
                                                            title="EPO Attachment - Click to enlarge">
                                                    </a>
                                                @else
                                                    <div class="no-image" title="EPO File Available">
                                                        <a href="{{ asset($project->epo_attachment) }}" target="_blank"
                                                            title="Download EPO File">
                                                            <i class="fas fa-file-alt text-success"
                                                                style="font-size: 20px;"></i>
                                                            <small class="text-success" style="font-size: 10px;">EPO
                                                                File</small>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="no-image" title="No EPO attachment uploaded">
                                                    <i class="fas fa-file-alt text-muted" style="font-size: 20px;"></i>
                                                    <small class="text-muted" style="font-size: 10px;">No EPO</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->customer_po_date)
                                                <span
                                                    class="badge badge-light badge-custom">{{ \Carbon\Carbon::parse($project->customer_po_date)->format('M d, Y') }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->customer_po_duration)
                                                <span
                                                    class="badge badge-secondary badge-custom">{{ $project->customer_po_duration }}
                                                    days</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->customer_po_deadline)
                                                @php
                                                    $deadline = \Carbon\Carbon::parse($project->customer_po_deadline);
                                                    $isOverdue = $deadline->isPast();
                                                @endphp
                                                <span class="{{ $isOverdue ? 'text-danger' : 'text-success' }}">
                                                    {{ $deadline->format('M d, Y') }}
                                                    @if ($isOverdue)
                                                        <i class="fas fa-exclamation-triangle" title="Overdue"></i>
                                                    @endif
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="project-description">
                                            @if ($project->description)
                                                <div class="text-wrap">
                                                    {{ $project->description }}
                                                </div>
                                            @else
                                                <div class="text-wrap">
                                                    N/A
                                                </div>
                                            @endif
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
    <!--Internal Datatable js -->
    <!-- <script src="{{ URL::asset('assets/js/table-data.js') }}"></script> --> <!-- Removed to avoid DataTable reinitialize conflict -->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)

            // Update form action URL with the project ID for delete route
            modal.find('form').attr('action', '{{ route('projects.destroy', ':id') }}'.replace(':id', id));
            modal.find('.modal-body #name').val(name);
        })

        // Initialize lightbox and DataTable
        $(document).ready(function() {
            // إعداد Lightbox
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': 'Image %1 of %2',
                'fadeDuration': 600,
                'imageFadeDuration': 600
            });

            // Initialize DataTable with export buttons
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm d-none',
                        title: 'Projects Report',
                        exportOptions: {
                            columns: ':not(:first-child):not(:nth-child(2))'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm d-none',
                        title: 'Projects Report',
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
                        title: 'Projects Report',
                        exportOptions: {
                            columns: ':not(:first-child):not(:nth-child(2))'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-warning btn-sm d-none',
                        title: 'Projects Report',
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
                columnDefs: [{
                        width: "5%",
                        targets: 0
                    }, // #
                    {
                        width: "10%",
                        targets: 1
                    }, // Actions
                    {
                        width: "8%",
                        targets: 2
                    }, // PR Number
                    {
                        width: "12%",
                        targets: 3
                    }, // Project Name
                    {
                        width: "8%",
                        targets: 4
                    }, // Technologies
                    {
                        width: "8%",
                        targets: 5
                    }, // Vendor
                    {
                        width: "6%",
                        targets: 6
                    }, // DS
                    {
                        width: "10%",
                        targets: 7
                    }, // Customer
                    {
                        width: "8%",
                        targets: 8
                    }, // Customer PO
                    {
                        width: "8%",
                        targets: 9
                    }, // Value
                    {
                        width: "8%",
                        targets: 10
                    }, // AC Manager
                    {
                        width: "8%",
                        targets: 11
                    }, // Project Manager
                    {
                        width: "10%",
                        targets: 12
                    }, // Customer Contact
                    {
                        width: "6%",
                        targets: 13
                    }, // PO Attachment
                    {
                        width: "6%",
                        targets: 14
                    }, // EPO Attachment
                    {
                        width: "8%",
                        targets: 15
                    }, // PO Date
                    {
                        width: "6%",
                        targets: 16
                    }, // Duration
                    {
                        width: "8%",
                        targets: 17
                    }, // Deadline
                    {
                        width: "10%",
                        targets: 18
                    } // Description
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
                printProjectsTable(); // Fallback to manual print
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
                printProjectsTable(); // Fallback to manual print
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
                const row = [],
                    cols = rows[i].querySelectorAll('td, th');

                for (let j = 2; j < cols.length; j++) { // Skip first two columns (# and Actions)
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
                    data = data.replace(/"/g, '""');
                    row.push('"' + data + '"');
                }
                csv.push(row.join(','));
            }

            const csvFile = new Blob([csv.join('\n')], {
                type: 'text/csv'
            });
            const downloadLink = document.createElement('a');
            downloadLink.download = 'projects_' + new Date().toISOString().slice(0, 10) + '.csv';
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        function printProjectsTable() {
            const printWindow = window.open('', '_blank');
            const table = document.getElementById('example1').cloneNode(true);

            // Remove action columns
            const actionCells = table.querySelectorAll('td:first-child, th:first-child, td:nth-child(2), th:nth-child(2)');
            actionCells.forEach(cell => cell.remove());

            const printContent = `
            <html>
            <head>
                <title>Projects Report</title>
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
                    <h2>Projects Report</h2>
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

    <!-- Export Functions -->
    <script src="{{ URL::asset('assets/js/export-functions.js') }}"></script>
@endsection
