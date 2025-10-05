@extends('layouts.master')

@section('title')
    PPOs Management
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
        /* تحسين شكل عرض التفاصيل */
        .ppo-details {
            max-width: 300px !important;
            min-width: 200px;
            white-space: normal !important;
        }

        .ppo-details .text-wrap {
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
        #example1 td.ppo-details {
            padding: 10px 8px;
            vertical-align: top;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .ppo-details {
                max-width: 250px !important;
            }

            .ppo-details .text-wrap {
                font-size: 12px;
                padding: 6px 8px;
            }

            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .btn-group {
                margin-bottom: 10px;
                margin-right: 0 !important;
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

        /* تحسين المودال */
        .modal-body textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-body textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .print-content, .print-content * {
                visibility: visible;
            }
            .print-content {
                position: absolute;
                left: 0;
                top: 0;
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
                    PPOs Management</span>
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
            'Edit' => 'success',
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
                            <h6 class="card-title mb-0">PPOs Management</h6>
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
                                    <a class="btn btn-primary" href="{{ route('ppos.create') }}">
                                        <i class="fas fa-plus"></i> Add PPO
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
                                    <th>PR Number</th>
                                    <th>Project Name</th>
                                    <th>PO Number</th>
                                    <th>Category</th>
                                    <th>Supplier Name</th>
                                    <th>Value</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Updates</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ppos as $index => $x)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('ppos.show', $x->id) }}"
                                                title="Show"><i class="las la-eye"></i></a>

                                            @can('Edit')
                                                <a class="btn btn-sm btn-info" href="{{ route('ppos.edit', $x->id) }}"
                                                    title="Update"><i class="las la-pen"></i></a>
                                            @endcan

                                            @can('Delete')
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $x->id }}" data-name="{{ $x->po_number }}"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="las la-trash"></i></a>
                                            @endcan
                                        </td>
                                        <td>{{ $x->project->pr_number ?? 'N/A' }}</td>
                                        <td>{{ $x->project->name ?? 'N/A' }}</td>
                                        <td>{{ $x->po_number }}</td>
                                        <td>{{ $x->pepo->category ?? 'N/A' }}</td>
                                        <td>{{ $x->ds->dsname ?? 'N/A' }}</td>
                                        <td>
                                            @if($x->value)
                                                ${{ number_format($x->value, 2) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $x->date ? $x->date->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="ppo-details">
                                            <div class="text-wrap">
                                                {{ $x->status ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="ppo-details">
                                            <div class="text-wrap">
                                                {{ $x->updates ?? 'No updates' }}
                                            </div>
                                        </td>
                                        <td class="ppo-details">
                                            <div class="text-wrap">
                                                {{ $x->notes ?? 'No notes' }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <i class="las la-inbox" style="font-size: 48px; color: #ccc;"></i>
                                            <p class="text-muted">No PPOs found</p>
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

    <!-- delete modal -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete PPO</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ url('ppos/destroy') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
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
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })

        // Export to PDF
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            doc.setFontSize(18);
            doc.text('PPOs Report', 14, 15);

            const tableData = [];
            const table = document.getElementById('example1');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                tableData.push([
                    cells[0].innerText, // #
                    cells[2].innerText, // PR Number
                    cells[3].innerText, // Project Name
                    cells[4].innerText, // Category
                    cells[5].innerText, // Supplier Name
                    cells[6].innerText, // PO Number
                    cells[7].innerText, // Value
                    cells[8].innerText, // Date
                    cells[9].innerText, // Status
                    cells[10].innerText, // Updates
                    cells[11].innerText  // Notes
                ]);
            }

            doc.autoTable({
                head: [['#', 'PR Number', 'Project Name', 'Category', 'Supplier', 'PO Number', 'Value', 'Date', 'Status', 'Updates', 'Notes']],
                body: tableData,
                startY: 20,
                styles: { fontSize: 8 }
            });

            doc.save('ppos_report.pdf');
        }

        // Export to Excel
        function exportToExcel() {
            const table = document.getElementById('example1');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            const data = [];

            // Add headers
            data.push(['#', 'PR Number', 'Project Name', 'Category', 'Supplier Name', 'PO Number', 'Value', 'Date', 'Status', 'Updates', 'Notes']);

            // Add data rows
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                data.push([
                    cells[0].innerText,
                    cells[2].innerText,
                    cells[3].innerText,
                    cells[4].innerText,
                    cells[5].innerText,
                    cells[6].innerText,
                    cells[7].innerText,
                    cells[8].innerText,
                    cells[9].innerText,
                    cells[10].innerText,
                    cells[11].innerText
                ]);
            }

            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'PPOs');
            XLSX.writeFile(wb, 'ppos_report.xlsx');
        }

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('example1');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            let csv = 'Number,PR Number,Project Name,Category,Supplier Name,PO Number,Value,Date,Status,Updates,Notes\n';

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const row = [
                    cells[0].innerText,
                    cells[2].innerText,
                    cells[3].innerText,
                    cells[4].innerText,
                    cells[5].innerText,
                    cells[6].innerText,
                    cells[7].innerText,
                    cells[8].innerText,
                    cells[9].innerText,
                    cells[10].innerText,
                    cells[11].innerText
                ].map(cell => `"${cell}"`).join(',');
                csv += row + '\n';
            }

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'ppos_report.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        // Print table
        function printTable() {
            window.print();
        }
    </script>
@endsection
