@extends('layouts.master')
@section('title')
    Project Tasks
@stop
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <style>
        .task-details {
            padding: 10px;
            margin: 5px 0;
            border-left: 4px solid #007bff;
            background-color: #f8f9fa;
            border-radius: 4px;
            max-height: 150px;
            overflow-y: auto;
        }
        .task-details .text-wrap {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                project tasks</span>
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

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Project Tasks List</h4>
                        <div>
                            <button onclick="exportToPDF()" class="btn btn-sm btn-danger mr-1">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button onclick="exportToExcel()" class="btn btn-sm btn-success mr-1">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button onclick="exportToCSV()" class="btn btn-sm btn-info mr-1">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                            <button onclick="printTable()" class="btn btn-sm btn-secondary mr-2">
                                <i class="fas fa-print"></i> Print
                            </button>
                            @can('Add')
                            <a class="btn btn-primary" href="{{ route('ptasks.create') }}">
                                <i class="fas fa-plus"></i> Add New Task
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover" id="ptasksTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operations</th>
                                    <th>PR Number</th>
                                    <th>Project Name</th>
                                    <th>Task Date</th>
                                    <th>Task Details</th>
                                    <th>Assigned To</th>
                                    <th>Expected Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ptasks as $i => $ptask)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ route('ptasks.show', $ptask->id) }}" title="Show">
                                                <i class="las la-eye"></i>
                                            </a>
                                            {{-- @can('Edit') --}}
                                            <a class="btn btn-sm btn-info" href="{{ route('ptasks.edit', $ptask->id) }}" title="Edit">
                                                <i class="las la-pen"></i>
                                            </a>
                                            {{-- @endcan --}}
                                            {{-- @can('Delete') --}}
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $ptask->id }}" data-task_details="{{ $ptask->details }}"
                                                data-toggle="modal" href="#modaldemo9" title="Delete">
                                                <i class="las la-trash"></i>
                                            </a>
                                            {{-- @endcan --}}
                                        </td>
                                        <td>{{ $ptask->project->pr_number ?? 'N/A' }}</td>
                                        <td>{{ $ptask->project->name ?? 'N/A' }}</td>
                                        <td>{{ $ptask->task_date ? \Carbon\Carbon::parse($ptask->task_date)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="task-details">
                                                <div class="text-wrap">{{ $ptask->details ?: 'No details' }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $ptask->assigned ?? 'Not assigned' }}</td>
                                        <td>{{ $ptask->expected_com_date ? \Carbon\Carbon::parse($ptask->expected_com_date)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            @if($ptask->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($ptask->status == 'progress')
                                                <span class="badge badge-warning">Under Progress</span>
                                            @elseif($ptask->status == 'pending')
                                                <span class="badge badge-info">Pending</span>
                                            @elseif($ptask->status == 'hold')
                                                <span class="badge badge-secondary">On Hold</span>
                                            @else
                                                <span class="badge badge-dark">{{ ucfirst($ptask->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No project task records found</td>
                                    </tr>
                                @endforelse
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
                <form action="ptasks/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="task_details" id="task_details" type="text" readonly>
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
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#ptasksTable').DataTable({
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
            doc.text('Project Tasks Report', 14, 15);
            doc.setFontSize(10);
            doc.text('Generated: ' + new Date().toLocaleString(), 14, 22);

            const headers = [['#', 'PR#', 'Project Name', 'Task Date', 'Details', 'Assigned', 'Expected', 'Status']];
            const data = [];

            $('#ptasksTable tbody tr').each(function(index) {
                if ($(this).find('td').length > 1) {
                    const row = [];
                    $(this).find('td').each(function(i) {
                        if (i === 0 || i > 1) {
                            row.push($(this).text().trim());
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
                styles: { fontSize: 8, cellPadding: 2 },
                columnStyles: {
                    0: { cellWidth: 10 },
                    4: { cellWidth: 40 }
                }
            });

            doc.save('project_tasks_' + new Date().getTime() + '.pdf');
        }

        // Export to Excel
        function exportToExcel() {
            const table = document.getElementById('ptasksTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Project Tasks" });
            XLSX.writeFile(wb, 'project_tasks_' + new Date().getTime() + '.xlsx');
        }

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('ptasksTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Project Tasks" });
            XLSX.writeFile(wb, 'project_tasks_' + new Date().getTime() + '.csv');
        }

        // Print Table
        function printTable() {
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Project Tasks</title>');
            printWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #ddd; padding: 8px; text-align: left;} th {background-color: #007bff; color: white;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>Project Tasks Report</h2>');
            printWindow.document.write('<p>Generated: ' + new Date().toLocaleString() + '</p>');
            printWindow.document.write(document.getElementById('ptasksTable').outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        // Delete Modal
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var task_details = button.data('task_details')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #task_details').val(task_details);
        })
    </script>
@endsection
