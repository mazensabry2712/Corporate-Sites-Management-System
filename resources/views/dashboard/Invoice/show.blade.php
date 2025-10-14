@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <style>
        .customer-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 20px;
        }

        .customer-logo {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .no-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 14px;
            text-align: center;
        }

        .info-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .info-value {
            font-size: 16px;
            color: #495057;
            font-weight: 500;
        }

        .empty-value {
            color: #ccc;
            font-style: italic;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-active {
            background-color: #28a745;
            color: white;
        }

        .type-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .type-default {
            background-color: #6c757d;
            color: white;
        }

        .customer-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #495057;
        }

        .customer-type {
            margin-top: 10px;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Export Button Styles */
        .btn-group .btn {
            border-radius: 0;
            border-right: 1px solid rgba(255,255,255,0.2);
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            border-right: none;
        }

        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                border-radius: 4px !important;
                margin-bottom: 5px;
                border-right: none;
            }

            .d-flex.my-xl-auto {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-body {
            padding: 2rem;
        }

        .control-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .customer-header {
                text-align: center;
                padding: 15px;
            }

            .customer-name {
                font-size: 1.5rem;
            }

            .info-card {
                padding: 15px;
            }
        }
    </style>
@endsection

@section('title')
    Invoice Details - {{ $invoice->invoice_number }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Invoice</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Details</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <!-- Export/Print Buttons -->
            <div class="btn-group mr-3 mb-3 mb-xl-0" role="group" aria-label="Export Options">
                <button type="button" class="btn btn-success btn-sm" onclick="exportToPDF()" title="Export to PDF">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="exportToExcel()" title="Export to Excel">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
                <button type="button" class="btn btn-info btn-sm" onclick="exportToCSV()" title="Export to CSV">
                    <i class="fas fa-file-csv"></i> CSV
                </button>
                <button type="button" class="btn btn-warning btn-sm" onclick="printInvoice()" title="Print">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="shareInvoice()" title="Share">
                    <i class="fas fa-share-alt"></i> Share
                </button>
            </div>

            @can('Edit')
                <div class="pr-1 mb-3 mb-xl-0">
                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-info btn-icon ml-2">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                </div>
            @endcan
            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('invoices.index') }}" class="btn btn-warning btn-icon ml-2">
                    <i class="mdi mdi-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Invoice Header -->
                    <div class="customer-header">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                @if($invoice->invoice_copy_path)
                                    @php
                                        $filePath = '../storge/' . $invoice->invoice_copy_path;
                                        $fileExtension = pathinfo($invoice->invoice_copy_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <a href="{{ asset($filePath) }}" data-lightbox="invoice-file" data-title="Invoice Copy - {{ $invoice->invoice_number }}">
                                            <img src="{{ asset($filePath) }}" alt="Invoice Copy" class="customer-logo">
                                        </a>
                                    @else
                                        <div class="no-logo">
                                            <div>
                                                <i class="fas fa-file-pdf fa-2x mb-2"></i>
                                                <div>PDF File</div>
                                                <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="no-logo">
                                        <div>
                                            <i class="fas fa-file-times fa-2x mb-2"></i>
                                            <div>No File</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <h1 class="customer-name">Invoice #{{ $invoice->invoice_number }}</h1>
                                <div class="customer-type">
                                    @if($invoice->status)
                                        <span class="type-badge type-active">
                                            {{ $invoice->status }}
                                        </span>
                                    @else
                                        <span class="type-badge type-default">No Status</span>
                                    @endif
                                </div>
                                @if($invoice->project && $invoice->project->pr_number)
                                    <div class="mt-2">
                                        <span class="badge badge-light" style="font-size: 1rem; padding: 8px 12px;">
                                            Project: {{ $invoice->project->pr_number }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Invoice Information -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="info-card">
                                <h3 class="section-title">
                                    <i class="fas fa-info-circle mr-2"></i>Invoice Information
                                </h3>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Invoice Number</div>
                                        <div class="info-value">{{ $invoice->invoice_number }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon" style="background-color: #17a2b8;">
                                        <i class="fas fa-project-diagram"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Project Number (PR)</div>
                                        <div class="info-value">{{ $invoice->project->pr_number ?? 'Not assigned' }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon" style="background-color: #6f42c1;">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Project Name</div>
                                        <div class="info-value">{{ $invoice->project->name ?? 'No name available' }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon" style="background-color: #28a745;">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Invoice Value</div>
                                        <div class="info-value">{{ number_format($invoice->value, 2) }} SAR</div>
                                    </div>
                                </div>

                                @if($invoice->project && $invoice->project->value)
                                    <div class="info-item">
                                        <div class="info-icon" style="background-color: #fd7e14;">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Project Total Value</div>
                                            <div class="info-value">{{ number_format($invoice->project->value, 2) }} SAR</div>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon" style="background-color: #e83e8c;">
                                            <i class="fas fa-percentage"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Invoice Percentage</div>
                                            <div class="info-value">
                                                {{ number_format(($invoice->value / $invoice->project->value) * 100, 2) }}%
                                                <small class="text-muted">({{ number_format($invoice->value, 2) }} of {{ number_format($invoice->project->value, 2) }} SAR)</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <div class="info-icon" style="background-color: #20c997;">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Status</div>
                                        <div class="info-value">{{ $invoice->status ?: 'No status provided' }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon" style="background-color: #6f42c1;">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Created At</div>
                                        <div class="info-value">{{ $invoice->created_at->format('Y-m-d H:i:s') }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon" style="background-color: #ffc107;">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Last Updated</div>
                                        <div class="info-value">{{ $invoice->updated_at->format('Y-m-d H:i:s') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice File Preview -->
                        <div class="col-lg-4">
                            <div class="info-card">
                                <h3 class="section-title">
                                    <i class="fas fa-file-invoice mr-2"></i>Invoice Copy
                                </h3>

                                @if($invoice->invoice_copy_path)
                                    @php
                                        $filePath = '../storge/' . $invoice->invoice_copy_path;
                                        $fileExtension = pathinfo($invoice->invoice_copy_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <div class="text-center mb-3">
                                            <a href="{{ asset($filePath) }}" data-lightbox="invoice-preview" data-title="Invoice Copy - {{ $invoice->invoice_number }}">
                                                <img src="{{ asset($filePath) }}" alt="Invoice Copy" class="img-fluid" style="max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            </a>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-primary btn-block">
                                                <i class="fas fa-eye"></i> View Full Image
                                            </a>
                                            <a href="{{ asset($filePath) }}" download class="btn btn-success btn-block mt-2">
                                                <i class="fas fa-download"></i> Download Image
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center mb-3">
                                            <div style="padding: 40px; background-color: #f8f9fa; border-radius: 8px;">
                                                <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                                                <h5>PDF Document</h5>
                                                <p class="text-muted">{{ $invoice->invoice_copy_path }}</p>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-danger btn-block">
                                                <i class="fas fa-eye"></i> View PDF
                                            </a>
                                            <a href="{{ asset($filePath) }}" download class="btn btn-success btn-block mt-2">
                                                <i class="fas fa-download"></i> Download PDF
                                            </a>
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        <div class="info-item">
                                            <div class="info-icon" style="background-color: #6c757d;">
                                                <i class="fas fa-file"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">File Name</div>
                                                <div class="info-value" style="font-size: 12px; word-break: break-all;">{{ $invoice->invoice_copy_path }}</div>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-icon" style="background-color: #17a2b8;">
                                                <i class="fas fa-code"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">File Type</div>
                                                <div class="info-value">{{ strtoupper($fileExtension) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-file-times fa-5x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Invoice Copy Available</h5>
                                        <p class="text-muted">No file has been uploaded for this invoice.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Quick Actions -->
                            <div class="info-card">
                                <h3 class="section-title">
                                    <i class="fas fa-bolt mr-2"></i>Quick Actions
                                </h3>

                                @can('Edit')
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-info btn-block mb-2">
                                        <i class="fas fa-edit"></i> Edit Invoice
                                    </a>
                                @endcan

                                <a href="{{ route('invoices.index') }}" class="btn btn-secondary btn-block mb-2">
                                    <i class="fas fa-list"></i> Back to List
                                </a>

                                @if($invoice->project)
                                    <a href="{{ route('projects.show', $invoice->project->id) }}" class="btn btn-primary btn-block mb-2">
                                        <i class="fas fa-project-diagram"></i> View Project
                                    </a>
                                @endif

                                @can('Delete')
                                    <button type="button" class="btn btn-danger btn-block" onclick="confirmDelete()">
                                        <i class="fas fa-trash"></i> Delete Invoice
                                    </button>

                                    <form id="delete-form" action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- Export Functions -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        // Export to PDF
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const element = document.querySelector('.card-body');

            html2canvas(element, {
                scale: 2,
                logging: false,
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgWidth = 210;
                const imgHeight = canvas.height * imgWidth / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                pdf.save('invoice-{{ $invoice->invoice_number }}.pdf');
            });
        }

        // Export to Excel
        function exportToExcel() {
            const data = [
                ['Invoice Number', '{{ $invoice->invoice_number }}'],
                ['Project Number', '{{ $invoice->project->pr_number ?? "N/A" }}'],
                ['Project Name', '{{ $invoice->project->name ?? "N/A" }}'],
                ['Invoice Value', '{{ number_format($invoice->value, 2) }} SAR'],
                @if($invoice->project && $invoice->project->value)
                ['Project Total Value', '{{ number_format($invoice->project->value, 2) }} SAR'],
                ['Invoice Percentage', '{{ number_format(($invoice->value / $invoice->project->value) * 100, 2) }}%'],
                @endif
                ['Status', '{{ $invoice->status }}'],
                ['Created At', '{{ $invoice->created_at->format("Y-m-d H:i:s") }}'],
                ['Updated At', '{{ $invoice->updated_at->format("Y-m-d H:i:s") }}']
            ];

            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Invoice Details');
            XLSX.writeFile(wb, 'invoice-{{ $invoice->invoice_number }}.xlsx');
        }

        // Export to CSV
        function exportToCSV() {
            const data = [
                ['Field', 'Value'],
                ['Invoice Number', '{{ $invoice->invoice_number }}'],
                ['Project Number', '{{ $invoice->project->pr_number ?? "N/A" }}'],
                ['Project Name', '{{ $invoice->project->name ?? "N/A" }}'],
                ['Invoice Value', '{{ number_format($invoice->value, 2) }} SAR'],
                @if($invoice->project && $invoice->project->value)
                ['Project Total Value', '{{ number_format($invoice->project->value, 2) }} SAR'],
                ['Invoice Percentage', '{{ number_format(($invoice->value / $invoice->project->value) * 100, 2) }}%'],
                @endif
                ['Status', '{{ $invoice->status }}'],
                ['Created At', '{{ $invoice->created_at->format("Y-m-d H:i:s") }}'],
                ['Updated At', '{{ $invoice->updated_at->format("Y-m-d H:i:s") }}']
            ];

            const csv = data.map(row => row.join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'invoice-{{ $invoice->invoice_number }}.csv';
            a.click();
        }

        // Print Invoice
        function printInvoice() {
            window.print();
        }

        // Share Invoice
        function shareInvoice() {
            if (navigator.share) {
                navigator.share({
                    title: 'Invoice #{{ $invoice->invoice_number }}',
                    text: 'Check out this invoice details',
                    url: window.location.href
                }).catch(err => console.log('Error sharing:', err));
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link copied to clipboard!');
                });
            }
        }

        // Confirm Delete
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }

        // Lightbox Configuration
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    </script>

    <style>
        @media print {
            .breadcrumb-header,
            .btn-group,
            .btn,
            .info-card:last-child {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
@endsection
