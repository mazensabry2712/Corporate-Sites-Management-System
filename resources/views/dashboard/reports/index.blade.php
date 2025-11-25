@extends('layouts.master')
@section('title')
  Reports | MDSJEDPR
@stop

@section('css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .customer-filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 30px;
    }

    .customer-filter-card h4 {
        color: #007bff;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-select-wrapper {
        position: relative;
    }

    .select2-container--default .select2-selection--single {
        background: #f8f9fa;
        border: 2px solid #007bff;
        border-radius: 10px;
        height: 50px;
        padding: 8px 15px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #0056b3;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px;
        font-size: 15px;
        color: #495057;
    }

    .btn-search-customer {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 0;
    }

    .btn-search-customer:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 123, 255, 0.4);
        color: white;
    }

    .customer-info-card {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
    }

    .customer-info-card h3 {
        font-weight: 700;
        margin-bottom: 15px;
    }

    .customer-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .customer-info-item i {
        width: 25px;
        text-align: center;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .stat-card .icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-card.projects .icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card.value .icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-card h5 {
        color: #6c757d;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: #007bff;
    }

    .projects-table-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .projects-table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
    }

    .projects-table-card .card-header h4 {
        margin: 0;
        font-weight: 700;
    }

    .table-modern {
        margin: 0;
    }

    .table-modern thead th {
        background: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border: none;
        padding: 15px;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .table-modern td {
        vertical-align: middle;
        padding: 15px;
        border-top: 1px solid #e9ecef;
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        color: #6c757d;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        color: #dee2e6;
    }

    .empty-state h4 {
        color: #495057;
        margin-bottom: 10px;
    }

    .loading-spinner {
        text-align: center;
        padding: 50px;
        display: none;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .loading-spinner.active {
        display: block;
    }

    .loading-spinner i {
        font-size: 48px;
        color: #007bff;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Toast Notifications */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }

    .toast-message {
        background: white;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    }

    .toast-message.success {
        border-left: 4px solid #28a745;
    }

    .toast-message.error {
        border-left: 4px solid #dc3545;
    }

    .toast-message.warning {
        border-left: 4px solid #ffc107;
    }

    .toast-message i {
        font-size: 24px;
    }

    .toast-message.success i {
        color: #28a745;
    }

    .toast-message.error i {
        color: #dc3545;
    }

    .toast-message.warning i {
        color: #ffc107;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    .btn-search-customer:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-search-customer {
            margin-top: 15px;
        }

        .toast-container {
            right: 10px;
            left: 10px;
        }

        .toast-message {
            min-width: auto;
        }
    }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4>
            <span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Customer Projects Filter</span>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- Toast Container --}}
<div class="toast-container" id="toastContainer"></div>

<div class="row">
    <div class="col-12">
        {{-- Customer Filter Card --}}
        <div class="customer-filter-card">
            <h4>
                <i class="fas fa-building"></i>
                Select Customer to View Projects
            </h4>
            <div class="row align-items-end">
                <div class="col-md-9">
                    <label for="customerSelect" class="form-label">Customer Name</label>
                    <div class="customer-select-wrapper">
                        <select id="customerSelect" class="form-control select2" data-placeholder="-- Select Customer --">
                            <option></option>
                            @foreach($filterOptions['customerNames'] as $customerName)
                                <option value="{{ $customerName }}">{{ $customerName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button id="btnSearchCustomer" class="btn btn-search-customer btn-block">
                        <i class="fas fa-search mr-2"></i>Search Projects
                    </button>
                </div>
            </div>
        </div>

        {{-- Loading Spinner --}}
        <div id="loadingSpinner" class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p class="mt-3">Loading customer projects...</p>
        </div>

        {{-- Customer Info Card --}}
        <div id="customerInfoCard" class="customer-info-card" style="display: none;">
            <h3 id="customerName"><i class="fas fa-building mr-2"></i></h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="customer-info-item">
                        <i class="fas fa-tag"></i>
                        <span>Abbreviation: <strong id="customerAbb"></strong></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="customer-info-item">
                        <i class="fas fa-list"></i>
                        <span>Type: <strong id="customerType"></strong></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div id="statsRow" class="stats-row" style="display: none;">
            <div class="stat-card projects">
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <h5>Total Projects</h5>
                <div class="number" id="totalProjects">0</div>
            </div>
            <div class="stat-card value">
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h5>Total Value</h5>
                <div class="number" id="totalValue">$0</div>
            </div>
        </div>

        {{-- Projects Table --}}
        <div id="projectsTableCard" class="projects-table-card" style="display: none;">
            <div class="card-header">
                <h4><i class="fas fa-list mr-2"></i>Customer Projects</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-hashtag mr-1"></i>PR Number</th>
                            <th><i class="fas fa-briefcase mr-1"></i>Project Name</th>
                            <th><i class="fas fa-dollar-sign mr-1"></i>Value</th>
                            <th><i class="fas fa-file-invoice mr-1"></i>PO Number</th>
                            <th><i class="fas fa-calendar mr-1"></i>Deadline</th>
                        </tr>
                    </thead>
                    <tbody id="projectsTableBody">
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Empty State --}}
        <div id="emptyState" class="empty-state" style="display: none;">
            <i class="fas fa-folder-open"></i>
            <h4>No Projects Found</h4>
            <p>This customer doesn't have any projects yet.</p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = $(`
            <div class="toast-message ${type}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'exclamation-triangle'}"></i>
                <div>
                    <strong>${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Warning'}!</strong>
                    <p style="margin: 5px 0 0 0; font-size: 14px;">${message}</p>
                </div>
            </div>
        `);

        $('#toastContainer').append(toast);

        setTimeout(() => {
            toast.css('animation', 'slideOut 0.3s ease');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Initialize Select2
    $('#customerSelect').select2({
        theme: 'default',
        width: '100%',
        placeholder: '-- Select Customer --',
        allowClear: true
    });

    // Search button click
    $('#btnSearchCustomer').on('click', function() {
        const customerName = $('#customerSelect').val();

        if (!customerName) {
            showToast('Please select a customer first', 'warning');
            $('#customerSelect').select2('open');
            return;
        }

        loadCustomerProjects(customerName);
    });

    // Also trigger on Enter key
    $('#customerSelect').on('select2:select', function() {
        const customerName = $(this).val();
        if (customerName) {
            loadCustomerProjects(customerName);
        }
    });

    // Function to load customer projects
    function loadCustomerProjects(customerName) {
        // Disable button during loading
        $('#btnSearchCustomer').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');

        // Show loading
        $('#loadingSpinner').addClass('active');
        $('#customerInfoCard, #statsRow, #projectsTableCard, #emptyState').hide();

        // Make AJAX request
        $.ajax({
            url: '{{ route("reports.customer.projects") }}',
            method: 'GET',
            data: { customer_name: customerName },
            success: function(response) {
                $('#loadingSpinner').removeClass('active');
                $('#btnSearchCustomer').prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Search Projects');

                if (response.success) {
                    // Show success message based on project count
                    if (response.total_projects > 0) {
                        showToast(`Found ${response.total_projects} projects for ${customerName}`, 'success');
                    } else {
                        showToast(`No projects found for ${customerName}`, 'warning');
                    }

                    // Display customer info
                    $('#customerName').html('<i class="fas fa-building mr-2"></i>' + escapeHtml(response.customer.name));
                    $('#customerAbb').text(response.customer.abb || 'N/A');
                    $('#customerType').text(response.customer.type || 'N/A');
                    $('#customerInfoCard').fadeIn();

                    // Display statistics
                    $('#totalProjects').text(response.total_projects);
                    $('#totalValue').text('$' + formatCurrency(response.total_value));
                    $('#statsRow').fadeIn();

                    // Hide both table and empty state first
                    $('#projectsTableCard').hide();
                    $('#emptyState').hide();

                    // Display projects table or empty state
                    if (response.projects && response.projects.length > 0) {
                        let tableRows = '';
                        response.projects.forEach((project, index) => {
                            tableRows += `
                                <tr>
                                    <td><span class="badge badge-primary">${index + 1}</span></td>
                                    <td><strong>${escapeHtml(project.pr_number)}</strong></td>
                                    <td>${escapeHtml(project.name)}</td>
                                    <td><strong class="text-success">$${escapeHtml(project.value)}</strong></td>
                                    <td>${escapeHtml(project.customer_po || 'N/A')}</td>
                                    <td>${escapeHtml(project.deadline || 'N/A')}</td>
                                </tr>
                            `;
                        });
                        $('#projectsTableBody').html(tableRows);
                        $('#projectsTableCard').fadeIn(300);
                    } else {
                        // Show empty state for customers with no projects
                        $('#emptyState').fadeIn(300);
                    }
                } else {
                    showToast(response.message || 'Failed to load customer projects', 'error');
                }
            },
            error: function(xhr) {
                $('#loadingSpinner').removeClass('active');
                $('#btnSearchCustomer').prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Search Projects');

                let errorMessage = 'An error occurred while loading customer projects';
                if (xhr.status === 404) {
                    errorMessage = 'Customer not found';
                } else if (xhr.status === 400) {
                    errorMessage = 'Invalid request';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showToast(errorMessage, 'error');
                console.error('AJAX Error:', xhr);
            }
        });
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Helper function to format currency
    function formatCurrency(value) {
        return Number(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
});
</script>
@endsection
