@extends('layouts.master')
@section('title')
    Project Status | MDSJEDPR
@stop
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <style>
        .pstatus-details {
            padding: 10px;
            margin: 5px 0;
            border-left: 4px solid #007bff;
            background-color: #f8f9fa;
            border-radius: 4px;
            max-height: 150px;
            overflow-y: auto;
        }
        .pstatus-details .text-wrap {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Project Status</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ All Status</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
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
    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
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


    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Project Status List</h4>
                        <div>
                            <button onclick="exportToPDF()" class="btn btn-sm btn-danger mr-1">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button onclick="exportToExcel()" class="btn btn-sm btn-success mr-1">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            {{-- <button onclick="exportToCSV()" class="btn btn-sm btn-info mr-1">
                                <i class="fas fa-file-csv"></i> CSV
                            </button> --}}
                            <button onclick="printTable()" class="btn btn-sm btn-secondary mr-2">
                                <i class="fas fa-print"></i> Print
                            </button>
                            @can('Add')
                            <a class="btn btn-primary" href="{{ route('pstatus.create') }}">
                                <i class="fas fa-plus"></i> Add New Status
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover" id="pstatusTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operations</th>
                                    <th>PR Number</th>
                                    <th>Project Name</th>
                                    <th>Date & Time</th>
                                    <th>PM Name</th>
                                    <th>Status</th>
                                    <th>Actual %</th>
                                    <th>Expected Date</th>
                                    <th>Pending Cost</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pstatus as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ route('pstatus.show', $item->id) }}" title="Show">
                                                <i class="las la-eye"></i>
                                            </a>
                                            {{-- @can('Edit') --}}
                                            <a class="btn btn-sm btn-info" href="{{ route('pstatus.edit', $item->id) }}" title="Edit">
                                                <i class="las la-pen"></i>
                                            </a>
                                            {{-- @endcan --}}
                                            {{-- @can('Delete') --}}
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $item->id }}" data-name="{{ $item->project->pr_number ?? 'N/A' }}"
                                                data-toggle="modal" href="#modaldemo9" title="Delete">
                                                <i class="las la-trash"></i>
                                            </a>
                                            {{-- @endcan --}}
                                        </td>
                                        <td>{{ $item->project->pr_number ?? 'N/A' }}</td>
                                        <td>{{ $item->project->name ?? 'N/A' }}</td>
                                        <td>{{ $item->date_time ? \Carbon\Carbon::parse($item->date_time)->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $item->ppm->name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="pstatus-details">
                                                <div class="text-wrap">{{ $item->status ?: 'No status' }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $item->actual_completion ? number_format($item->actual_completion, 2) . '%' : 'N/A' }}</td>
                                        <td>{{ $item->expected_completion ? \Carbon\Carbon::parse($item->expected_completion)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="pstatus-details">
                                                <div class="text-wrap">{{ $item->date_pending_cost_orders ?: 'N/A' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pstatus-details">
                                                <div class="text-wrap">{{ $item->notes ?: 'No notes' }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No project status records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="pstatus/destroy" method="post">
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


    </div>
    @endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pstatusTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 25,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                }
            });
        });

        // Export to PDF
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            doc.setFontSize(18);
            doc.text('Project Status Report', 14, 15);
            doc.setFontSize(10);
            doc.text('Generated: ' + new Date().toLocaleString(), 14, 22);

            const headers = [['#', 'PR Number', 'Project Name', 'Date & Time', 'PM Name', 'Status', 'Actual %', 'Expected', 'Pending', 'Notes']];
            const data = [];

            $('#pstatusTable tbody tr').each(function(index) {
                if ($(this).find('td').length > 1) {
                    const row = [];
                    // يتم استبعاد العمود 1 (Operations)
                    $(this).find('td').each(function(i) {
                        if (i === 0 || i > 1) {
                            row.push($(this).text().trim().replace(/\s+/g, ' '));
                        }
                    });
                    data.push(row);
                }
            });

            doc.autoTable({
                head: headers,
                body: data,
                startY: 28,
                theme: 'grid',
                headStyles: { fillColor: [0, 123, 255], textColor: 255 },
                styles: { fontSize: 8, cellPadding: 2, overflow: 'linebreak' },
                columnStyles: {
                    0: { cellWidth: 8 },
                    4: { cellWidth: 20 }, // Date & Time
                    5: { cellWidth: 20 }, // PM Name
                    6: { cellWidth: 40 }, // Status
                    8: { cellWidth: 20 }, // Expected
                    9: { cellWidth: 35 }, // Pending Cost
                    10: { cellWidth: 35 } // Notes
                }
            });

            doc.save('project_status_' + new Date().getTime() + '.pdf');
        }

        // Export to Excel (تم تعديلها لاستبعاد عمود العمليات)
        function exportToExcel() {
            const data = [];

            // إضافة العناوين
            const headerRow = ['#', 'PR Number', 'Project Name', 'Date & Time', 'PM Name', 'Status', 'Actual %', 'Expected Date', 'Pending Cost', 'Notes'];
            data.push(headerRow);

            // إضافة البيانات
            $('#pstatusTable tbody tr').each(function() {
                const row = [];
                $(this).find('td').each(function(i) {
                    // استبعاد عمود العمليات (Index 1)
                    if (i === 0 || i > 1) {
                        row.push($(this).text().trim().replace(/\s+/g, ' '));
                    }
                });
                if (row.length > 1) { // التأكد من أنها ليست صف "No records found"
                    data.push(row);
                }
            });

            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Project Status');
            XLSX.writeFile(wb, 'project_status_' + new Date().getTime() + '.xlsx');
        }

        // Print Table
        function printTable() {
            window.print();
        }

        // Delete Modal
        $('#modaldemo9').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const name = button.data('name');
            const modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        });
    </script>
@endsection
