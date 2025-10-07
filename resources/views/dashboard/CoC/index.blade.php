@extends('layouts.master')
@section('title')
    Certificate of Compliance | MDSJEDPR
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
        .no-file {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 50px;
            width: 50px;
            border: 1px dashed #ccc;
            border-radius: 4px;
        }

        /* تحسين شكل عرض اسم المشروع */
        .project-name {
            max-width: 200px !important;
            min-width: 150px;
            white-space: normal !important;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .project-name .badge {
            display: inline-block;
            max-width: 100%;
            word-wrap: break-word;
            white-space: normal;
            line-height: 1.4;
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

        .image-thumbnail {
            cursor: pointer;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s ease;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .image-thumbnail:hover {
            border-color: #007bff;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
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

        .alert-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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

        /* تأكيد عدم الاختفاء السريع */
        .alert.fade.show {
            opacity: 1 !important;
        }

        /* Date styling */
        .date-info {
            font-size: 12px;
            color: #6c757d;
        }

        .date-info i {
            margin-right: 4px;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Certificate of Compliance</span>
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
                <i class="fas fa-check-circle mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Success!</strong>
                    <div>{{ session()->get('Add') }}</div>
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
        <div class="alert alert-info alert-dismissible fade show"
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
                            <h6 class="card-title mb-0">Certificate of Compliance Management</h6>
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
                                    <a class="btn btn-primary" data-effect="effect-scale" href="{{ route('coc.create') }}">
                                        <i class="fas fa-plus"></i> Add CoC
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
                                    <th>CoC File</th>
                                    <th>Upload Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($coc as $item)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            {{-- @can('Show') --}}
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('coc.show', $item->id) }}" title="View">
                                                    <i class="las la-eye"></i>
                                                </a>
                                            {{-- @endcan --}}

                                            @can('Edit')
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('coc.edit', $item->id) }}" title="Update">
                                                    <i class="las la-pen"></i>
                                                </a>
                                            @endcan

                                            @can('Delete')
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $item->id }}"
                                                    data-project_name="{{ $item->project->name ?? 'N/A' }}"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                        <td>
                                            @if($item->project && $item->project->pr_number)
                                                <span class="badge badge-primary" style="font-size: 11px; padding: 5px 10px;">
                                                    <i class="fas fa-hashtag mr-1"></i>
                                                    {{ $item->project->pr_number }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="project-name">
                                            @if($item->project && $item->project->name)
                                                <span class="badge badge-info" style="font-size: 12px; padding: 6px 10px;">
                                                    <i class="fas fa-project-diagram mr-1"></i>
                                                    {{ $item->project->name }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary" style="font-size: 11px; padding: 5px 8px;">
                                                    No project assigned
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->coc_copy && file_exists(public_path('../storge/' . $item->coc_copy)))
                                                @php
                                                    $fileExtension = pathinfo($item->coc_copy, PATHINFO_EXTENSION);
                                                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    $filePath = '../storge/' . $item->coc_copy;
                                                @endphp

                                                @if($isImage)
                                                    <a href="{{ asset($filePath) }}" data-lightbox="gallery-{{$item->id}}"
                                                        data-title="CoC Copy - {{ $item->project->name ?? 'N/A' }}" title="Click to view full size">
                                                        <img src="{{ asset($filePath) }}" alt="CoC Copy"
                                                             height="50" width="50" class="image-thumbnail"
                                                             title="CoC Copy - Click to enlarge">
                                                    </a>
                                                @else
                                                    <a href="{{ asset($filePath) }}" target="_blank"
                                                       title="Click to view/download file" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-file-pdf"></i> View File
                                                    </a>
                                                @endif
                                            @else
                                                <div class="no-file" title="No file uploaded">
                                                    <i class="fas fa-file text-muted" style="font-size: 20px;"></i>
                                                    <small class="text-muted" style="font-size: 10px;">No File</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $item->created_at->format('Y-m-d') }}
                                            </div>
                                            <div class="date-info">
                                                <i class="fas fa-clock"></i>
                                                {{ $item->created_at->format('h:i A') }}
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

    <!-- Delete Modal -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Certificate of Compliance</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('coc.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Certificate of Compliance?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group">
                            <label for="project_name">Project:</label>
                            <input class="form-control" name="project_name" id="project_name" type="text" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
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

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- jsPDF & html2canvas for PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- SheetJS for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        // Delete Modal
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var project_name = button.data('project_name');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #project_name').val(project_name);
        });

        // Export to PDF
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            doc.setFontSize(18);
            doc.text('Certificate of Compliance List', 15, 15);
            doc.setFontSize(10);
            doc.text('Generated on: ' + new Date().toLocaleDateString(), 15, 22);

            const table = document.getElementById('example1');
            const rows = [];

            const headers = ['#', 'PR Number', 'Project', 'Upload Date'];
            rows.push(headers);

            const dataRows = table.querySelectorAll('tbody tr');
            dataRows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1,
                    cells[2]?.textContent.trim().replace(/\s+/g, ' ') || '',
                    cells[3]?.textContent.trim().replace(/\s+/g, ' ') || '',
                    cells[5]?.textContent.trim().replace(/\s+/g, ' ') || ''
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

            doc.save('CoC_List_' + new Date().toISOString().slice(0,10) + '.pdf');
        }

        // Export to Excel
        function exportToExcel() {
            const table = document.getElementById('example1');
            const wb = XLSX.utils.book_new();

            const data = [];
            data.push(['#', 'PR Number', 'Project', 'Upload Date']);

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                data.push([
                    index + 1,
                    cells[2]?.textContent.trim().replace(/\s+/g, ' ') || '',
                    cells[3]?.textContent.trim().replace(/\s+/g, ' ') || '',
                    cells[5]?.textContent.trim().replace(/\s+/g, ' ') || ''
                ]);
            });

            const ws = XLSX.utils.aoa_to_sheet(data);

            // Set column widths
            ws['!cols'] = [
                { wch: 5 },
                { wch: 15 },
                { wch: 30 },
                { wch: 20 }
            ];

            XLSX.utils.book_append_sheet(wb, ws, 'CoC List');
            XLSX.writeFile(wb, 'CoC_List_' + new Date().toISOString().slice(0,10) + '.xlsx');
        }

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('example1');
            let csv = [];

            csv.push(['#', 'PR Number', 'Project', 'Upload Date'].join(','));

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1,
                    '"' + (cells[2]?.textContent.trim().replace(/\s+/g, ' ').replace(/"/g, '""') || '') + '"',
                    '"' + (cells[3]?.textContent.trim().replace(/\s+/g, ' ').replace(/"/g, '""') || '') + '"',
                    cells[5]?.textContent.trim().replace(/\s+/g, ' ') || ''
                ];
                csv.push(rowData.join(','));
            });

            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'CoC_List_' + new Date().toISOString().slice(0,10) + '.csv';
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

        // Configure Lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    </script>
@endsection
