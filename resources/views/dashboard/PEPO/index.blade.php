@extends('layouts.master')
@section('title')
    Project EPO | MDSJEDPR
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
        /* تحسين شكل الجدول */
        #example1 {
            width: 100% !important;
            table-layout: auto;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
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

        /* تحسين Badge الـ Margin */
        .badge {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Epo</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Success!</strong>
                    <div>{{ session()->get('Add') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Error!</strong>
                    <div>{{ session()->get('Error') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-trash mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Deleted!</strong>
                    <div>{{ session()->get('delete') }}</div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-edit mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Updated!</strong>
                    <div>{{ session()->get('edit') }}</div>
                </div>
            </div>
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
                            <h6 class="card-title mb-0">Epo Management</h6>
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
                                    <a class="btn btn-primary" data-effect="effect-scale" href="{{ route('epo.create') }}">
                                        <i class="fas fa-plus"></i> Add Epo
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
                                    <th>Category</th>
                                    <th>Planned Cost</th>
                                    <th>Selling Price</th>
                                    <th>Margin (%)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pepo as $i => $x)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td style="white-space: nowrap;">
                                            {{-- @can('Show') --}}
                                                <a class="btn btn-sm btn-primary" href="{{ route('epo.show', $x->id) }}"
                                                    title="View"><i class="las la-eye"></i></a>
                                            {{-- @endcan --}}

                                            {{-- @can('Edit') --}}
                                                <a class="btn btn-sm btn-info" href="{{ route('epo.edit', $x->id) }}"

                                                    title="Update"><i class="las la-pen"></i></a>
                                            {{-- @endcan --}}

                                            {{-- @can('Delete') --}}
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $x->id }}" data-name="{{ $x->category }}"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="las la-trash"></i></a>
                                            {{-- @endcan --}}
                                        </td>
                                        <td>{{ $x->project->pr_number ?? 'N/A' }}</td>
                                        <td>{{ $x->project->name ?? 'N/A' }}</td>
                                        <td>{{ $x->category ?? '-' }}</td>
                                        <td>{{ number_format($x->planned_cost, 2) }}</td>
                                        <td>{{ number_format($x->selling_price, 2) }}</td>
                                        <td>
                                            @if($x->margin !== null)
                                                <span class="badge badge-{{ $x->margin >= 0.2 ? 'success' : ($x->margin >= 0.1 ? 'warning' : 'danger') }}">
                                                    {{ number_format($x->margin * 100, 2) }}%
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No EPO records found</td>
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
                <form action="epo/destroy" method="post">
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

    <!-- jsPDF with autoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

    <!-- SheetJS for Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        // Delete Modal
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
            const doc = new jsPDF();

            doc.setFontSize(16);
            doc.text('Epo Report', 14, 15);
            doc.setFontSize(10);
            doc.text('Generated on: ' + new Date().toLocaleDateString(), 14, 22);

            const table = document.getElementById('example1');
            const rows = [];

            rows.push(['#', 'PR Number', 'Project Name', 'Category', 'Planned Cost', 'Selling Price', 'Margin (%)']);

            const tableRows = table.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1,
                    cells[2]?.textContent.trim() || '',
                    cells[3]?.textContent.trim() || '',
                    cells[4]?.textContent.trim() || '',
                    cells[5]?.textContent.trim() || '',
                    cells[6]?.textContent.trim() || '',
                    cells[7]?.textContent.trim() || ''
                ];
                rows.push(rowData);
            });

            doc.autoTable({
                head: [rows[0]],
                body: rows.slice(1),
                startY: 30,
                theme: 'grid',
                styles: {
                    fontSize: 9,
                    cellPadding: 3
                },
                headStyles: {
                    fillColor: [41, 128, 185],
                    textColor: 255,
                    fontStyle: 'bold'
                }
            });

            doc.save('Epo_Report_' + new Date().toISOString().slice(0,10) + '.pdf');
        }

        // Export to Excel
        function exportToExcel() {
            const table = document.getElementById('example1');
            const wb = XLSX.utils.book_new();

            const data = [];
            data.push(['#', 'PR Number', 'Project Name', 'Category', 'Planned Cost', 'Selling Price', 'Margin (%)']);

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                data.push([
                    index + 1,
                    cells[2]?.textContent.trim() || '',
                    cells[3]?.textContent.trim() || '',
                    cells[4]?.textContent.trim() || '',
                    cells[5]?.textContent.trim() || '',
                    cells[6]?.textContent.trim() || '',
                    cells[7]?.textContent.trim() || ''
                ]);
            });

            const ws = XLSX.utils.aoa_to_sheet(data);

            ws['!cols'] = [
                { wch: 5 },
                { wch: 15 },
                { wch: 25 },
                { wch: 20 },
                { wch: 15 },
                { wch: 15 },
                { wch: 15 }
            ];

            XLSX.utils.book_append_sheet(wb, ws, 'Epo Data');
            XLSX.writeFile(wb, 'Epo_Report_' + new Date().toISOString().slice(0,10) + '.xlsx');
        }

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('example1');
            let csv = [];

            csv.push(['#', 'PR Number', 'Project Name', 'Category', 'Planned Cost', 'Selling Price', 'Margin (%)'].join(','));

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1,
                    '"' + (cells[2]?.textContent.trim().replace(/"/g, '""') || '') + '"',
                    '"' + (cells[3]?.textContent.trim().replace(/"/g, '""') || '') + '"',
                    '"' + (cells[4]?.textContent.trim().replace(/"/g, '""') || '') + '"',
                    cells[5]?.textContent.trim() || '',
                    cells[6]?.textContent.trim() || '',
                    cells[7]?.textContent.trim() || ''
                ];
                csv.push(rowData.join(','));
            });

            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Epo_Report_' + new Date().toISOString().slice(0,10) + '.csv';
            link.click();
        }

        // Print Table
        function printTable() {
            window.print();
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endsection
