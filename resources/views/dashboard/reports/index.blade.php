@extends('layouts.master')
@section('title')
    Reports
@stop

@section('css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .reports-container {
        display: flex;
        gap: 20px;
        position: relative;
    }

    .filter-sidebar {
        width: 320px;
        flex-shrink: 0;
        position: sticky;
        top: 80px;
        height: fit-content;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    }

    .filter-sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .filter-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .filter-sidebar::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .filter-sidebar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .sidebar-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #dee2e6;
    }

    .sidebar-header h5 {
        color: #495057;
        font-weight: 700;
        font-size: 18px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-header h5 i {
        color: #667eea;
        font-size: 20px;
    }

    .active-filters-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 10px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .reports-content {
        flex: 1;
        min-width: 0;
    }

    .filter-card {
        background: white;
        border: none;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }

    .filter-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-card .card-header:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .filter-card .card-header h6 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-card .card-header h6 i:first-child {
        margin-right: 8px;
    }

    .filter-card .card-header .toggle-icon {
        transition: transform 0.3s ease;
        font-size: 12px;
    }

    .filter-card .card-header.collapsed .toggle-icon {
        transform: rotate(180deg);
    }

    .filter-card .card-body {
        padding: 15px;
        background: #ffffff;
    }

    .filter-card label {
        color: #495057;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .filter-card label i {
        color: #667eea;
        font-size: 10px;
    }

    .filter-card .form-control {
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 6px;
        font-size: 13px;
        padding: 10px 12px;
        transition: all 0.3s ease;
    }

    .filter-card .form-control:hover {
        background: #ffffff;
        border-color: #e9ecef;
    }

    .filter-card .form-control:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-card .form-control::placeholder {
        color: #adb5bd;
        font-size: 12px;
    }

    .filter-card select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
    }

    .filter-card select.form-control option {
        padding: 10px;
    }

    .select2-container--default .select2-selection--single {
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 6px;
        height: 42px;
        padding: 6px 12px;
    }

    .select2-container--default .select2-selection--single:hover {
        background: #ffffff;
        border-color: #e9ecef;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #495057;
        line-height: 28px;
        font-size: 13px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }

    .select2-dropdown {
        border: 2px solid #667eea;
        border-radius: 6px;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #667eea;
    }

    .filter-card .form-group {
        margin-bottom: 12px;
        position: relative;
    }

    .filter-card .form-group:last-child {
        margin-bottom: 0;
    }

    .filter-card .input-icon {
        position: absolute;
        right: 12px;
        top: 35px;
        color: #adb5bd;
        pointer-events: none;
        font-size: 12px;
    }

    .filter-actions {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 15px;
        box-shadow: 0 -4px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        margin-top: 15px;
        z-index: 10;
    }

    .btn-filter {
        width: 100%;
        margin-bottom: 10px;
        padding: 12px 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    }

    .btn-filter i {
        margin-right: 8px;
    }

    .btn-reset {
        width: 100%;
        padding: 10px 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-reset i {
        margin-right: 8px;
    }

    .badge-completion {
        font-size: 11px;
        padding: 5px 10px;
    }

    .export-buttons .btn {
        margin-left: 5px;
    }

    /* Collapse Animation */
    .collapse {
        transition: height 0.35s ease;
    }

    @media (max-width: 992px) {
        .reports-container {
            flex-direction: column;
        }

        .filter-sidebar {
            width: 100%;
            position: relative;
            max-height: none;
            top: 0;
        }
    }

    /* Loading Overlay */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-overlay.active {
        display: flex;
    }

    .loading-spinner {
        text-align: center;
    }

    .loading-spinner i {
        font-size: 48px;
        color: #667eea;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-spinner p {
        margin-top: 15px;
        color: #495057;
        font-weight: 600;
    }
</style>
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Reports with Advanced Filters</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
    {{-- Loading Overlay --}}
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Loading Reports...</p>
        </div>
    </div>

    <div class="reports-container">
        {{-- Sidebar Filters --}}
        <div class="filter-sidebar">
            {{-- Sidebar Header --}}
            <div class="sidebar-header">
                <h5>
                    <i class="fas fa-filter"></i>
                    Advanced Filters
                    @if(request()->has('filter'))
                        <span class="active-filters-badge">{{ count(array_filter(request('filter', []))) }} Active</span>
                    @endif
                </h5>
            </div>

            <form action="{{ route('reports.index') }}" method="GET" id="filterForm">
                {{-- Filter 1: Project Information --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#projectInfo">
                        <h6>
                            <span><i class="fas fa-project-diagram"></i> Project Information</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="projectInfo" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-hashtag"></i> PR Number</label>
                                <select name="filter[pr_number]" class="form-control select2">
                                    <option value="">-- Select PR Number --</option>
                                    @foreach($prNumbers as $prNumber)
                                        <option value="{{ $prNumber }}" {{ request('filter.pr_number') == $prNumber ? 'selected' : '' }}>
                                            {{ $prNumber }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-briefcase"></i> Project Name</label>
                                <select name="filter[name]" class="form-control select2" data-placeholder="-- Select Project --">
                                    <option></option>
                                    @foreach($projectNames as $projectName)
                                        <option value="{{ $projectName }}" {{ request('filter.name') == $projectName ? 'selected' : '' }}>
                                            {{ $projectName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-code"></i> Technologies</label>
                                <select name="filter[technologies]" class="form-control select2" data-placeholder="-- Select Technology --">
                                    <option></option>
                                    @foreach($technologies as $technology)
                                        <option value="{{ $technology }}" {{ request('filter.technologies') == $technology ? 'selected' : '' }}>
                                            {{ $technology }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-user-tie"></i> Project Manager</label>
                                <select name="filter[project_manager]" class="form-control select2" data-placeholder="-- Select PM --">
                                    <option></option>
                                    @foreach($projectManagers as $pm)
                                        <option value="{{ $pm }}" {{ request('filter.project_manager') == $pm ? 'selected' : '' }}>
                                            {{ $pm }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 2: Customer & Partners --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#customerPartners">
                        <h6>
                            <span><i class="fas fa-users"></i> Customer & Partners</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="customerPartners" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-building"></i> Customer Name</label>
                                <select name="filter[customer_name]" class="form-control select2" data-placeholder="-- Select Customer --">
                                    <option></option>
                                    @foreach($customerNames as $customerName)
                                        <option value="{{ $customerName }}" {{ request('filter.customer_name') == $customerName ? 'selected' : '' }}>
                                            {{ $customerName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-file-invoice"></i> Customer PO</label>
                                <select name="filter[customer_po]" class="form-control select2" data-placeholder="-- Select PO --">
                                    <option></option>
                                    @foreach($customerPos as $customerPo)
                                        <option value="{{ $customerPo }}" {{ request('filter.customer_po') == $customerPo ? 'selected' : '' }}>
                                            {{ $customerPo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-handshake"></i> Vendors</label>
                                <select name="filter[vendors]" class="form-control select2" data-placeholder="-- Select Vendor --">
                                    <option></option>
                                    @foreach($vendorsList as $vendor)
                                        <option value="{{ $vendor }}" {{ request('filter.vendors') == $vendor ? 'selected' : '' }}>
                                            {{ $vendor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-truck"></i> Suppliers</label>
                                <select name="filter[suppliers]" class="form-control select2" data-placeholder="-- Select Supplier --">
                                    <option></option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier }}" {{ request('filter.suppliers') == $supplier ? 'selected' : '' }}>
                                            {{ $supplier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-user-cog"></i> Account Manager</label>
                                <select name="filter[am]" class="form-control select2" data-placeholder="-- Select AM --">
                                    <option></option>
                                    @foreach($ams as $am)
                                        <option value="{{ $am }}" {{ request('filter.am') == $am ? 'selected' : '' }}>
                                            {{ $am }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 3: Financial --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#financial">
                        <h6>
                            <span><i class="fas fa-dollar-sign"></i> Financial</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="financial" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-arrow-down"></i> Value Min ($)</label>
                                <input type="number" step="0.01" name="filter[value_min]" class="form-control" placeholder="e.g., 50000" value="{{ request('filter.value_min') }}">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-arrow-up"></i> Value Max ($)</label>
                                <input type="number" step="0.01" name="filter[value_max]" class="form-control" placeholder="e.g., 500000" value="{{ request('filter.value_max') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 4: Completion & Deadline --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#completion">
                        <h6>
                            <span><i class="fas fa-calendar-check"></i> Completion & Deadline</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="completion" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt"></i> Deadline From</label>
                                <input type="date" name="filter[deadline_from]" class="form-control" value="{{ request('filter.deadline_from') }}">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt"></i> Deadline To</label>
                                <input type="date" name="filter[deadline_to]" class="form-control" value="{{ request('filter.deadline_to') }}">
                            </div>
                            {{-- TODO: Enable after adding completion_percentage column to projects table --}}
                            {{-- <div class="form-group">
                                <label><i class="fas fa-percent"></i> Completion Min (%)</label>
                                <input type="number" step="0.01" name="filter[completion_min]" class="form-control" placeholder="e.g., 0" value="{{ request('filter.completion_min') }}" disabled>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-percent"></i> Completion Max (%)</label>
                                <input type="number" step="0.01" name="filter[completion_max]" class="form-control" placeholder="e.g., 100" value="{{ request('filter.completion_max') }}" disabled>
                            </div> --}}
                        </div>
                    </div>
                </div>

                {{-- Filter Actions --}}
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-filter">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-reset">
                        <i class="fas fa-redo"></i> Reset All
                    </a>
                </div>
            </form>
        </div>

        {{-- Results Content --}}
        <div class="reports-content">
                    {{-- Results Card --}}
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Reports Data</h6>
                            <p class="text-muted tx-12 mb-0">Total Results: <strong>{{ $reports->count() }}</strong></p>
                        </div>
                        <div class="btn-group export-buttons" role="group">
                            <button type="button" class="btn btn-sm btn-danger" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="exportToCSV()">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                            <button type="button" class="btn btn-sm btn-info" onclick="printTable()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-nowrap" id="example1">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th style="width: 50px;">#</th>
                                    <th>PR Number</th>
                                    <th>Project Name</th>
                                    <th>Project Manager</th>
                                    <th>Technologies</th>
                                    <th>Customer Name</th>
                                    <th>Customer PO</th>
                                    <th>Value ($)</th>
                                    <th>Invoice Total</th>
                                    <th>Deadline</th>
                                    <th>Completion %</th>
                                    <th>Vendors</th>
                                    <th>Suppliers</th>
                                    <th>AM</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $index => $report)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge badge-info">{{ $report->pr_number ?? 'N/A' }}</span></td>
                                        <td><strong>{{ $report->name ?? 'N/A' }}</strong></td>
                                        <td>{{ $report->ppms->name ?? 'N/A' }}</td>
                                        <td><span class="badge badge-secondary">{{ $report->technologies ?? 'N/A' }}</span></td>
                                        <td>{{ $report->cust->name ?? 'N/A' }}</td>
                                        <td>{{ $report->customer_po ?? 'N/A' }}</td>
                                        <td class="text-right"><strong>${{ number_format($report->value ?? 0, 2) }}</strong></td>
                                        <td class="text-right">N/A</td>
                                        <td>{{ $report->customer_po_deadline ? \Carbon\Carbon::parse($report->customer_po_deadline)->format('d M Y') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-secondary badge-completion">N/A</span>
                                        </td>
                                        <td>{{ $report->vendor->vendors ?? 'N/A' }}</td>
                                        <td>{{ $report->ds->dsname ?? 'N/A' }}</td>
                                        <td>{{ $report->aams->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-center text-muted py-5">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                            <h5>No Projects Found</h5>
                                            <p>Try adjusting your filters or reset to see all projects.</p>
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
@endsection

@section('js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for all select boxes
        $('.select2').each(function() {
            var placeholder = $(this).data('placeholder') || 'Select an option';
            $(this).select2({
                theme: 'default',
                width: '100%',
                placeholder: placeholder,
                allowClear: true
            });
        });

        // Initialize DataTable
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: []
        });

        // Collapse/Expand Filter Sections
        $('.filter-card .card-header').on('click', function() {
            $(this).toggleClass('collapsed');
            var target = $(this).data('target');
            $(target).collapse('toggle');
        });

        // Show loading overlay on form submit
        $('#filterForm').on('submit', function() {
            $('#loadingOverlay').addClass('active');
        });

        // Auto-hide loading after page load
        $(window).on('load', function() {
            $('#loadingOverlay').removeClass('active');
        });

        // Highlight active filters for select boxes
        $('.select2').on('change', function() {
            if ($(this).val() === '' || $(this).val() === null) {
                $(this).next('.select2-container').find('.select2-selection').css('border-color', 'transparent');
            } else {
                $(this).next('.select2-container').find('.select2-selection').css('border-color', '#667eea');
            }
        });

        // Highlight already selected filters on page load
        $('.select2').each(function() {
            if ($(this).val() !== '' && $(this).val() !== null) {
                $(this).next('.select2-container').find('.select2-selection').css('border-color', '#667eea');
            }
        });

        // Clear individual filter on input clear
        $('.form-control:not(.select2)').on('input', function() {
            if ($(this).val() === '') {
                $(this).css('border-color', 'transparent');
            } else {
                $(this).css('border-color', '#667eea');
            }
        });

        // Highlight active filters for regular inputs
        $('.form-control:not(.select2)').each(function() {
            if ($(this).val() !== '') {
                $(this).css('border-color', '#667eea');
            }
        });
    });

    function exportToPDF() {
        alert('PDF Export functionality - integrate with library like jsPDF');
    }

    function exportToExcel() {
        alert('Excel Export functionality - integrate with library');
    }

    function exportToCSV() {
        var table = document.getElementById('example1');
        var csv = [];
        var rows = table.querySelectorAll('tr');

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll('td, th');
            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
            csv.push(row.join(','));
        }

        var csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
        var downloadLink = document.createElement('a');
        downloadLink.download = 'reports.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }

    function printTable() {
        window.print();
    }
</script>
@endsection
