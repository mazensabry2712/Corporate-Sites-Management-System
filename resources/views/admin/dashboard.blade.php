@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .sales-card {
            border-radius: 15px !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12) !important;
            margin-bottom: 20px;
        }

        .sales-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2) !important;
        }

        .stats-icon {
            font-size: 1.8rem;
            opacity: 0.25;
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .card-content {
            position: relative;
            z-index: 2;
        }

        .stats-number {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
        }

        .stats-label {
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ========== FILTER SIDEBAR STYLES - MATCHING REPORTS ========== */
        .dashboard-filter-container {
            display: flex;
            gap: 25px;
            position: relative;
            margin-top: 0;
            width: 100%;
            padding: 0;
        }

        .filter-sidebar {
            width: 350px;
            flex-shrink: 0;
            height: fit-content;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 30px rgba(0, 123, 255, 0.15);
            border: 2px solid rgba(0, 123, 255, 0.15);
            position: relative;
        }

        .filter-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            border-radius: 15px 15px 0 0;
        }

        .filter-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .filter-sidebar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0056b3 0%, #007bff 100%);
        }

        .sidebar-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #007bff;
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #0056b3;
        }

        .sidebar-header h5 {
            color: #007bff;
            font-weight: 800;
            font-size: 20px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-header h5 i {
            color: #007bff;
            font-size: 22px;
            animation: filterPulse 2s ease-in-out infinite;
        }

        @keyframes filterPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .active-filters-badge {
            display: inline-block;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .active-filters-summary {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #007bff;
        }

        .active-filters-summary .badge {
            font-size: 10px;
            padding: 5px 10px;
            font-weight: 500;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
        }

        .filter-card {
            background: white;
            border: none;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .filter-card:hover {
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
        }

        .filter-card .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            border-radius: 8px 8px 0 0;
            padding: 12px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-card .card-header:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }

        .filter-card .card-header h6 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: #495057;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-card .card-header h6 span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-card .card-header h6 i.fas {
            color: #007bff;
            font-size: 14px;
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            color: #007bff;
            font-size: 12px;
        }

        .collapsed .toggle-icon {
            transform: rotate(180deg);
        }

        .filter-card .card-body {
            padding: 15px;
        }

        .filter-card label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-card label i {
            color: #007bff;
            font-size: 11px;
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
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
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
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .filter-actions {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 15px;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
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

        .btn-apply-filter {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
        }

        .btn-reset-filter {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            color: white;
        }

        .dashboard-content-area {
            flex: 1;
            min-width: 0;
        }

        .dashboard-content-area .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 25px rgba(0, 123, 255, 0.12);
            overflow: hidden;
        }

        .dashboard-content-area .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            padding: 20px 25px;
        }

        .dashboard-content-area .card-body {
            padding: 40px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .dashboard-filter-container {
                flex-direction: column;
            }

            .filter-sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .sales-card {
                margin-bottom: 15px;
            }
        }

        /* Print styles for PDF */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
            }

            .page-break {
                page-break-after: always;
            }
        }

        /* Button hover effect */
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome back!</h2>
            </div>
        </div>
        {{-- <div class="main-dashboard-header-right">
						<div>
							<label class="tx-13">Customer Ratings</label>
							<div class="main-star">
								<i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star"></i> <span>(14,873)</span>
							</div>
						</div>
						<div>
							<label class="tx-13">Online Sales</label>
							<h5>563,275</h5>
						</div>
						<div>
							<label class="tx-13">Offline Sales</label>
							<h5>783,675</h5>
						</div>
					</div> --}}
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">

        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-users text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">👥 Users</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $userCount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total System Users</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-project-diagram text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📊 Projects</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $projectcount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Active Projects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-handshake text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">🤝 Customers</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $custCount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total Customers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-user-tie text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">💼 PMs</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $pmCount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Active PMs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-user-cog text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">⚙️ AMs</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $amCount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Active AMs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-truck text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">🚛 Vendors</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $VendorsCount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total Vendors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-shipping-fast text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📦 D/S</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $dsCount }}</h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total Partners</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-receipt text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">🧾 Invoices</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $invoiceCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total Invoices</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-info-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-file-alt text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📄 DNs</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $dnCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">All DNs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-certificate text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📜 COCs</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $cocCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total COCs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-file-contract text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📋 POs</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $posCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Active POs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-tasks text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📊 Status</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $statusCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total Status</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- row 2 -->
    <div class="row row-sm">

        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-clipboard-list text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">✅ Tasks</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $tasksCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Active Tasks</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-file-signature text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">📝 EPOs</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $epoCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Total EPOs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-exclamation-triangle text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">⚠️ Risks</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $reskCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Identified Risks</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-2 pr-3 pb-2">
                    <i class="fas fa-flag-checkered text-white stats-icon" style="font-size: 1.8rem;"></i>
                    <div class="card-content">
                        <h6 class="mb-2 tx-11 text-white stats-label">🏁 Milestones</h6>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $milestonesCount }}
                                    </h4>
                                    <p class="mb-0 tx-10 text-white op-7">Achieved Goals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    {{-- ========== FILTER SECTION WITH SIDEBAR ========== --}}
    <div class="row row-sm mt-4">
        <div class="col-12">
            <div class="dashboard-filter-container">
                {{-- Sidebar Filters --}}
                <div class="filter-sidebar">
                    {{-- Sidebar Header --}}
                    <div class="sidebar-header">
                        <h5>
                            <i class="fas fa-filter"></i>
                            Advanced Filters
                        </h5>
                    </div>

                    <form action="{{ route('dashboard.index') }}" method="GET" id="filterForm">
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

                                    <!-- PR Number Filter -->

                                    <div class="form-group">
                                        <label><i class="fas fa-hashtag"></i> PR Number</label>
                                        <select name="filter[pr_number]" class="form-control select2"
                                            data-placeholder="-- Select PR Number --">
                                            <option></option>
                                            <option value="all"
                                                {{ request('filter.pr_number') == 'all' ? 'selected' : '' }}>All Projects
                                                ({{ $projectcount }})</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->pr_number }}"
                                                    {{ request('filter.pr_number') == $project->pr_number ? 'selected' : '' }}>
                                                    {{ $project->pr_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Project Name Filter -->
                                    {{-- <div class="form-group">
                                        <label><i class="fas fa-briefcase"></i> Project Name</label>
                                        <select name="filter[project_name]" class="form-control select2"
                                            data-placeholder="-- Select Project Name --">
                                            <option></option>
                                            <option value="all"
                                                {{ request('filter.project_name') == 'all' ? 'selected' : '' }}>All Projects
                                                ({{ $projectcount }})</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->name }}"
                                                    {{ request('filter.project_name') == $project->name ? 'selected' : '' }}>
                                                    {{ $project->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}



                                </div>
                            </div>
                        </div>


                        {{-- Filter Actions --}}
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-filter btn-apply-filter">
                                <i class="fas fa-search"></i> Apply Filters
                            </button>
                            <button type="button" class="btn btn-filter btn-reset-filter" onclick="resetFilters()">
                                <i class="fas fa-undo"></i> Reset All
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Dashboard Content Area --}}
                <div class="dashboard-content-area">
                    @if ($hasFilters && $filteredProjects->count() > 0)
                        {{-- Project Details Section --}}
                        @foreach ($filteredProjects as $project)
                            <div class="row row-sm mb-4">
                                {{-- Project Information Card --}}
                                <div class="col-12 mb-4">
                                    <div class="card" style="border-radius: 15px; border: 3px solid #007bff; box-shadow: 0 6px 30px rgba(0, 123, 255, 0.2);">
                                        <div class="card-header" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); padding: 25px;">
                                            <h3 class="text-white mb-0">
                                                <i class="fas fa-project-diagram"></i> {{ $project->name }}
                                                <span class="badge badge-light ml-2" style="font-size: 14px;">PR# {{ $project->pr_number }}</span>
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 30px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                                            {{-- Project Info Grid --}}
                                            <div class="row mb-4">
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #007bff; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                                                        <small class="text-muted d-block mb-2"><i class="fas fa-building"></i> Customer</small>
                                                        <h5 class="mb-0" style="color: #007bff;">{{ $project->cust->name ?? 'N/A' }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #28a745; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                                                        <small class="text-muted d-block mb-2"><i class="fas fa-user-tie"></i> Project Manager</small>
                                                        <h5 class="mb-0" style="color: #28a745;">{{ $project->ppms->name ?? 'N/A' }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #ffc107; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                                                        <small class="text-muted d-block mb-2"><i class="fas fa-dollar-sign"></i> Project Value</small>
                                                        <h5 class="mb-0" style="color: #ffc107;">{{ number_format($project->value ?? 0, 2) }} SAR</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #dc3545; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                                                        <small class="text-muted d-block mb-2"><i class="fas fa-calendar-alt"></i> PO Date</small>
                                                        <h5 class="mb-0" style="color: #dc3545;">{{ $project->customer_po_date ?? 'N/A' }}</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Progress Bar - Always Show --}}
                                            @php
                                                $totalTasks = $project->tasks->count();
                                                $completedTasks = $project->tasks->whereIn('status', ['Completed', 'completed'])->count();
                                                $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

                                                // Statistics for Print/PDF
                                                $totalTasksCount = $project->tasks->count();
                                                $tasksCompleted = $project->tasks->whereIn('status', ['Completed', 'completed'])->count();
                                                $totalRisks = $project->risks->count();
                                                $highRisks = $project->risks->whereIn('impact', ['High', 'high'])->count();
                                                $totalMilestones = $project->milestones->count();
                                                $milestonesDone = $project->milestones->whereIn('status', ['Completed', 'completed', 'on track'])->count();
                                                $totalInvoices = $project->invoices->count();
                                                $invoicesPaid = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();
                                                $assignedNames = $project->tasks->pluck('assigned')->filter()->unique()->implode('|');
                                                $riskNames = $project->risks->pluck('risk')->filter()->unique()->implode('|');
                                                $closedRisks = $project->risks->whereIn('status', ['closed'])->count();
                                                $milestoneNames = $project->milestones->pluck('milestone')->filter()->unique()->implode('|');
                                                $invoiceNumbers = $project->invoices->pluck('invoice_number')->filter()->unique()->implode('|');
                                            @endphp

                                            <div id="progress-section-{{ $project->id }}" class="mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); padding: 25px; border-radius: 15px; box-shadow: 0 3px 20px rgba(0,0,0,0.1); border: 1px solid #e9ecef;">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <div>
                                                        <h5 class="mb-1" style="color: #2c3e50; font-weight: 700;">
                                                            <i class="fas fa-chart-line" style="color: #28a745;"></i> Project Progress
                                                        </h5>
                                                        <small class="text-muted">Task completion status</small>
                                                    </div>
                                                    <div class="text-right d-flex align-items-center" style="gap: 10px;">
                                                        <button onclick="printProgress('{{ addslashes($project->name) }}', '{{ $project->pr_number }}', '{{ $project->cust->name ?? 'N/A' }}', '{{ $project->ppms->name ?? 'N/A' }}', '{{ number_format($project->value ?? 0, 2) }}', '{{ $project->customer_po_date ?? 'N/A' }}', {{ $completedTasks }}, {{ $totalTasks }}, {{ $progress }}, {{ $totalTasksCount }}, {{ $tasksCompleted }}, {{ $totalRisks }}, {{ $highRisks }}, {{ $totalMilestones }}, {{ $milestonesDone }}, {{ $totalInvoices }}, {{ $invoicesPaid }}, '{{ $assignedNames }}', '{{ $riskNames }}', {{ $closedRisks }}, '{{ $milestoneNames }}', '{{ $invoiceNumbers }}')"
                                                                class="btn btn-sm no-print"
                                                                style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                                                                       color: white;
                                                                       padding: 10px 18px;
                                                                       border: none;
                                                                       border-radius: 8px;
                                                                       font-weight: 600;
                                                                       font-size: 14px;
                                                                       box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
                                                                       cursor: pointer;
                                                                       transition: all 0.3s ease;">
                                                            <i class="fas fa-print mr-1"></i> Print
                                                        </button>
                                                        <a href="{{ route('dashboard.export.pdf', $project->pr_number) }}"
                                                                class="btn btn-sm no-print"
                                                                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                                                                       color: white;
                                                                       padding: 10px 18px;
                                                                       border: none;
                                                                       border-radius: 8px;
                                                                       font-weight: 600;
                                                                       font-size: 14px;
                                                                       box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
                                                                       cursor: pointer;
                                                                       transition: all 0.3s ease;
                                                                       text-decoration: none;
                                                                       display: inline-block;">
                                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                                        </a>
                                                        <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                                                    color: white;
                                                                    font-size: 24px;
                                                                    font-weight: 700;
                                                                    padding: 12px 24px;
                                                                    border-radius: 12px;
                                                                    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                                                                    min-width: 100px;
                                                                    text-align: center;">
                                                            {{ $progress }}%
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Progress Bar - Always Show --}}
                                                <div style="background: #e9ecef;
                                                            height: 30px;
                                                            border-radius: 15px;
                                                            overflow: hidden;
                                                            position: relative;
                                                            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);">
                                                    <div style="background: linear-gradient(90deg, #28a745 0%, #34ce57 100%);
                                                                height: 100%;
                                                                width: {{ $progress }}%;
                                                                border-radius: 15px;
                                                                transition: width 0.6s ease;
                                                                position: relative;
                                                                box-shadow: 0 2px 8px rgba(40, 167, 69, 0.4);">
                                                    </div>
                                                </div>

                                                {{-- Completed and Total Boxes - Always Show --}}
                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
                                                                    padding: 20px;
                                                                    border-radius: 12px;
                                                                    border-left: 4px solid #28a745;
                                                                    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.15);">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <div style="color: #155724; font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                                                                        <i class="fas fa-check-circle"></i> COMPLETED
                                                                    </div>
                                                                    <div style="color: #28a745; font-size: 32px; font-weight: 700;">
                                                                        {{ $completedTasks }}
                                                                    </div>
                                                                </div>
                                                                <i class="fas fa-check-double" style="font-size: 40px; color: #28a745; opacity: 0.2;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div style="background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
                                                                    padding: 20px;
                                                                    border-radius: 12px;
                                                                    border-left: 4px solid #6c757d;
                                                                    box-shadow: 0 2px 10px rgba(108, 117, 125, 0.15);">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <div style="color: #495057; font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                                                                        <i class="fas fa-list"></i> TOTAL TASKS
                                                                    </div>
                                                                    <div style="color: #495057; font-size: 32px; font-weight: 700;">
                                                                        {{ $totalTasks }}
                                                                    </div>
                                                                </div>
                                                                <i class="fas fa-tasks" style="font-size: 40px; color: #6c757d; opacity: 0.2;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Statistics Cards --}}
                                            <div class="row">
                                                {{-- Tasks Statistics --}}
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9;">Tasks Assigned To</small>
                                                                <div style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto; margin-top: 8px;">
                                                                    @php
                                                                        $assignedNames = $project->tasks->pluck('assigned')->filter()->unique();
                                                                    @endphp
                                                                    @if($assignedNames->count() > 0)
                                                                        @foreach($assignedNames as $name)
                                                                            <div style="padding: 4px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">• {{ $name }}</div>
                                                                        @endforeach
                                                                    @else
                                                                        <div style="opacity: 0.7;">No tasks</div>
                                                                    @endif
                                                                </div>
                                                                <small style="opacity: 0.8; display: block; margin-top: 8px;">{{ $project->tasks->whereIn('status', ['Completed', 'completed'])->count() }}/{{ $project->tasks->count() }} Completed</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Risks Statistics --}}
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9;">Risk/Issue</small>
                                                                <div style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto; margin-top: 8px;">
                                                                    @php
                                                                        $riskNames = $project->risks->pluck('risk')->filter()->unique();
                                                                    @endphp
                                                                    @if($riskNames->count() > 0)
                                                                        @foreach($riskNames as $risk)
                                                                            <div style="padding: 4px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">• {{ $risk }}</div>
                                                                        @endforeach
                                                                    @else
                                                                        <div style="opacity: 0.7;">No risks</div>
                                                                    @endif
                                                                </div>
                                                                <small style="opacity: 0.8; display: block; margin-top: 8px;">{{ $project->risks->whereIn('status', ['closed'])->count() }}/{{ $project->risks->count() }} Closed</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Milestones Statistics --}}
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9;">Milestone</small>
                                                                <div style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto; margin-top: 8px;">
                                                                    @php
                                                                        $milestoneNames = $project->milestones->pluck('milestone')->filter()->unique();
                                                                    @endphp
                                                                    @if($milestoneNames->count() > 0)
                                                                        @foreach($milestoneNames as $milestone)
                                                                            <div style="padding: 4px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">• {{ $milestone }}</div>
                                                                        @endforeach
                                                                    @else
                                                                        <div style="opacity: 0.7;">No milestones</div>
                                                                    @endif
                                                                </div>
                                                                <small style="opacity: 0.8; display: block; margin-top: 8px;">{{ $project->milestones->whereIn('status', ['Completed', 'completed', 'on track'])->count() }}/{{ $project->milestones->count() }} Done</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Invoices Statistics --}}
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9;">Invoice Number</small>
                                                                <div style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto; margin-top: 8px;">
                                                                    @php
                                                                        $invoiceNumbers = $project->invoices->pluck('invoice_number')->filter()->unique();
                                                                    @endphp
                                                                    @if($invoiceNumbers->count() > 0)
                                                                        @foreach($invoiceNumbers as $invoice)
                                                                            <div style="padding: 4px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">• {{ $invoice }}</div>
                                                                        @endforeach
                                                                    @else
                                                                        <div style="opacity: 0.7;">No invoices</div>
                                                                    @endif
                                                                </div>
                                                                <small style="opacity: 0.8; display: block; margin-top: 8px;">{{ $project->invoices->whereIn('status', ['paid', 'Paid'])->count() }}/{{ $project->invoices->count() }} Paid</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- No Filters Applied Message --}}
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="card"
                                    style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 123, 255, 0.15);">
                                    <div class="card-header"
                                        style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 15px 15px 0 0;">
                                        <h4 class="card-title text-white mb-0">
                                            <i class="fas fa-chart-line"></i> Filtered Dashboard Data
                                        </h4>
                                    </div>
                                    <div class="card-body" style="min-height: 400px;">
                                        <div class="text-center py-5">
                                            <i class="fas fa-chart-bar"
                                                style="font-size: 4rem; color: #007bff; opacity: 0.3;"></i>
                                            <h5 class="mt-4" style="color: #6c757d;">Apply filters to view customized
                                                data</h5>
                                            <p class="text-muted">Use the filters on the left to narrow down your dashboard
                                                view</p>
                                            <div class="mt-4">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    Select filters and click "Apply Filters" to see results
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Filter section closed -->
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- html2pdf.js library for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                allowClear: true
            });

            // Toggle collapse icons
            $('.card-header[data-toggle="collapse"]').on('click', function() {
                $(this).find('.toggle-icon').toggleClass('collapsed');
            });

            // Smooth scroll animation for filter sidebar
            $('.filter-sidebar').on('scroll', function() {
                var scrollTop = $(this).scrollTop();
                if (scrollTop > 50) {
                    $(this).addClass('scrolled');
                } else {
                    $(this).removeClass('scrolled');
                }
            });
        });

        // Reset Filters Function
        function resetFilters() {
            // Clear all select2 selections
            $('.select2').val(null).trigger('change');

            // Clear all form inputs
            $('#filterForm')[0].reset();

            // Redirect to dashboard without filters
            window.location.href = '{{ route('dashboard.index') }}';
        }

        // Form submission with loading indicator
        $('#filterForm').on('submit', function(e) {
            // Show loading state
            $('.btn-apply-filter').html('<i class="fas fa-spinner fa-spin"></i> Applying...').prop('disabled',
            true);
        });

        // Collapse all filters function
        function collapseAllFilters() {
            $('.collapse').collapse('hide');
        }

        // Expand all filters function
        function expandAllFilters() {
            $('.collapse').collapse('show');
        }

        // Print Progress Function (للطباعة المباشرة)
        function printProgress(projectName, prNumber, customer, pm, value, poDate, completed, total, progress, totalTasksCount, tasksCompleted, totalRisks, highRisks, totalMilestones, milestonesDone, totalInvoices, invoicesPaid, assignedNames, riskNames, closedRisks, milestoneNames, invoiceNumbers) {
            const printWindow = window.open('', '_blank', 'width=1200,height=800');

            const now = new Date();
            const dateStr = now.toLocaleDateString('en-GB', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const timeStr = now.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit'
            });

            printWindow.document.write(generateProgressHTML(projectName, prNumber, customer, pm, value, poDate, completed, total, progress, totalTasksCount, tasksCompleted, totalRisks, highRisks, totalMilestones, milestonesDone, totalInvoices, invoicesPaid, assignedNames, riskNames, closedRisks, milestoneNames, invoiceNumbers, dateStr, timeStr, false));
            printWindow.document.close();

            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.print();
                    // إغلاق النافذة بعد الطباعة
                    setTimeout(function() {
                        printWindow.close();
                    }, 1000);
                }, 500);
            };
        }

        // PDF export now handled by server-side TCPDF (see route: dashboard.export.pdf)
        // Old exportToPDF function removed - using Laravel Controller instead

        // Generate HTML for Progress Report (for Print functionality only)
        function generateProgressHTML(projectName, prNumber, customer, pm, value, poDate, completed, total, progress, totalTasksCount, tasksCompleted, totalRisks, highRisks, totalMilestones, milestonesDone, totalInvoices, invoicesPaid, dateStr, timeStr, isPDF) {
            // التحقق من وجود html2pdf (not used anymore)
            if (false && typeof html2pdf === 'undefined') {
                alert('جاري تحميل مكتبة PDF... الرجاء المحاولة مرة أخرى بعد لحظات.');
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
                script.onload = function() {
                    alert('تم تحميل المكتبة. يمكنك الآن تصدير PDF.');
                };
                document.head.appendChild(script);
                return;
            }

            const now = new Date();
            const dateStr = now.toLocaleDateString('en-GB', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const timeStr = now.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit'
            });

            // Create temporary element with full HTML content
            const tempDiv = document.createElement('div');
            tempDiv.style.position = 'absolute';
            tempDiv.style.left = '-9999px';
            tempDiv.style.width = '210mm';
            tempDiv.style.backgroundColor = 'white';
            tempDiv.style.padding = '0';
            tempDiv.style.margin = '0';

            tempDiv.innerHTML = `
                <div style="width: 210mm; background: white; padding: 15mm; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <div style="text-align: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 3px solid #28a745;">
                        <h1 style="color: #2c3e50; font-size: 22px; margin: 0 0 5px 0; font-weight: 700;">
                            📊 Project Progress Report
                        </h1>
                        <div style="color: #6c757d; font-size: 12px;">Task Completion Analysis</div>
                    </div>

                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 12px 15px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #007bff;">
                        <h2 style="color: #2c3e50; font-size: 18px; margin: 0 0 5px 0; font-weight: 700;">${projectName}</h2>
                        <span style="background: #007bff; color: white; padding: 4px 12px; border-radius: 5px; font-size: 12px; font-weight: 600; display: inline-block;">PR# ${prNumber}</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px;">
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 10px 12px; border: 1px solid #e9ecef;">
                            <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 16px; margin-bottom: 8px;">🏢</div>
                            <div style="font-size: 10px; color: #6c757d; text-transform: uppercase; margin-bottom: 3px; font-weight: 600;">CUSTOMER</div>
                            <div style="font-size: 12px; color: #2c3e50; font-weight: 700;">${customer}</div>
                        </div>
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 10px 12px; border: 1px solid #e9ecef;">
                            <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 16px; margin-bottom: 8px;">👔</div>
                            <div style="font-size: 10px; color: #6c757d; text-transform: uppercase; margin-bottom: 3px; font-weight: 600;">PROJECT MANAGER</div>
                            <div style="font-size: 12px; color: #2c3e50; font-weight: 700;">${pm}</div>
                        </div>
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 10px 12px; border: 1px solid #e9ecef;">
                            <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 16px; margin-bottom: 8px;">💰</div>
                            <div style="font-size: 10px; color: #6c757d; text-transform: uppercase; margin-bottom: 3px; font-weight: 600;">PROJECT VALUE</div>
                            <div style="font-size: 12px; color: #2c3e50; font-weight: 700;">${value} SAR</div>
                        </div>
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 10px 12px; border: 1px solid #e9ecef;">
                            <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 16px; margin-bottom: 8px;">📅</div>
                            <div style="font-size: 10px; color: #6c757d; text-transform: uppercase; margin-bottom: 3px; font-weight: 600;">PO DATE</div>
                            <div style="font-size: 12px; color: #2c3e50; font-weight: 700;">${poDate}</div>
                        </div>
                    </div>

                    <div style="background: white; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <div style="font-size: 16px; color: #2c3e50; font-weight: 700;">📋 Progress Overview</div>
                            <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; font-size: 20px; font-weight: 700; padding: 8px 18px; border-radius: 10px;">${progress}%</div>
                        </div>
                        <div style="background: #e9ecef; height: 24px; border-radius: 12px; overflow: hidden; margin-bottom: 15px;">
                            <div style="background: linear-gradient(90deg, #28a745 0%, #34ce57 100%); height: 100%; width: ${progress}%; border-radius: 12px;"></div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #28a745;">
                                <div style="font-size: 10px; font-weight: 600; color: #155724; margin-bottom: 5px; text-transform: uppercase;">✅ COMPLETED TASKS</div>
                                <div style="font-size: 28px; font-weight: 700; color: #28a745;">${completed}</div>
                            </div>
                            <div style="background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #6c757d;">
                                <div style="font-size: 10px; font-weight: 600; color: #495057; margin-bottom: 5px; text-transform: uppercase;">📝 TOTAL TASKS</div>
                                <div style="font-size: 28px; font-weight: 700; color: #495057;">${total}</div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 14px; border-radius: 8px; margin-bottom: 12px;">
                            <h3 style="margin: 0; font-size: 15px;">📊 Project Statistics</h3>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                            <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 12px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">Tasks</div>
                                <div style="font-size: 24px; font-weight: 700;">${totalTasksCount}</div>
                                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px;">${tasksCompleted} Completed</div>
                            </div>
                            <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 12px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">Risks</div>
                                <div style="font-size: 24px; font-weight: 700;">${totalRisks}</div>
                                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px;">${highRisks} High</div>
                            </div>
                            <div style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white; padding: 12px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">Milestones</div>
                                <div style="font-size: 24px; font-weight: 700;">${totalMilestones}</div>
                                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px;">${milestonesDone} Done</div>
                            </div>
                            <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 12px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">Invoices</div>
                                <div style="font-size: 24px; font-weight: 700;">${totalInvoices}</div>
                                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px;">${invoicesPaid} Paid</div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 15px; padding-top: 10px; border-top: 2px solid #dee2e6; text-align: center;">
                        <div style="color: #6c757d; font-size: 10px; margin-bottom: 4px;"><strong>MDSJEDPR</strong> - Corporate Sites Management System</div>
                        <div style="color: #495057; font-size: 9px; font-style: italic;">Report generated on ${dateStr} at ${timeStr}</div>
                    </div>
                </div>
            `;

            document.body.appendChild(tempDiv);

            // Enhanced PDF settings
            const opt = {
                margin: [5, 5, 5, 5],
                filename: `Project_PR${prNumber}_${projectName.replace(/\s+/g, '_')}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.95
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    letterRendering: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                    windowWidth: 794, // A4 width in pixels at 96 DPI
                    windowHeight: 1123 // A4 height in pixels at 96 DPI
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait',
                    compress: true
                }
            };

            // Display loading message
            const loadingMsg = document.createElement('div');
            loadingMsg.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 20px 40px; border-radius: 10px; z-index: 10000; font-size: 16px;';
            loadingMsg.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
            document.body.appendChild(loadingMsg);

            // Generate and download PDF
            html2pdf()
                .set(opt)
                .from(tempDiv)
                .save()
                .then(function() {
                    // Remove temporary elements
                    if (tempDiv && tempDiv.parentNode) {
                        document.body.removeChild(tempDiv);
                    }
                    if (loadingMsg && loadingMsg.parentNode) {
                        document.body.removeChild(loadingMsg);
                    }
                    console.log('✅ PDF created successfully');
                })
                .catch(function(error) {
                    console.error('❌ PDF Error:', error);
                    // Remove temporary elements even in case of error
                    if (tempDiv && tempDiv.parentNode) {
                        document.body.removeChild(tempDiv);
                    }
                    if (loadingMsg && loadingMsg.parentNode) {
                        document.body.removeChild(loadingMsg);
                    }
                    alert('An error occurred while generating PDF:\n' + error.message + '\n\nPlease try again.');
                });
        }

        // Generate HTML for Progress Report
        function generateProgressHTML(projectName, prNumber, customer, pm, value, poDate, completed, total, progress, totalTasksCount, tasksCompleted, totalRisks, highRisks, totalMilestones, milestonesDone, totalInvoices, invoicesPaid, assignedNames, riskNames, closedRisks, milestoneNames, invoiceNumbers, dateStr, timeStr, isPDF) {
            return `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Project Progress Report - ${projectName}</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <style>
                        @page {
                            size: A4 portrait;
                            margin: 10mm 15mm;
                        }

                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }

                        body {
                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            padding: 0;
                            margin: 0;
                            background: white;
                            color: #333;
                            line-height: 1.3;
                            font-size: 11px;
                        }

                        .page-container {
                            max-width: 210mm;
                            margin: 0 auto;
                            padding: 10mm 15mm;
                            background: white;
                        }

                        .logo-header {
                            text-align: center;
                            margin-bottom: 12px;
                            padding-bottom: 8px;
                            border-bottom: 3px solid #28a745;
                        }

                        .logo-header h1 {
                            color: #2c3e50;
                            font-size: 20px;
                            margin: 0 0 4px 0;
                            font-weight: 700;
                        }

                        .logo-header .subtitle {
                            color: #6c757d;
                            font-size: 11px;
                            font-weight: 400;
                        }

                        .project-header {
                            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                            padding: 15px 20px;
                            border-radius: 10px;
                            margin-bottom: 15px;
                            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
                        }

                        .project-header h2 {
                            color: white;
                            font-size: 18px;
                            margin: 0 0 5px 0;
                            font-weight: 700;
                        }

                        .project-header .pr-badge {
                            display: inline-block;
                            background: white;
                            color: #007bff;
                            padding: 4px 12px;
                            border-radius: 5px;
                            font-weight: 700;
                            font-size: 12px;
                        }

                        .project-details {
                            margin-bottom: 12px;
                        }

                        .details-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr 1fr 1fr;
                            gap: 10px;
                        }

                        .detail-item {
                            background: white;
                            border-radius: 8px;
                            padding: 12px 15px;
                            text-align: center;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                        }

                        .detail-item.customer {
                            border-left: 5px solid #007bff;
                        }

                        .detail-item.pm {
                            border-left: 5px solid #28a745;
                        }

                        .detail-item.value {
                            border-left: 5px solid #ffc107;
                        }

                        .detail-item.po-date {
                            border-left: 5px solid #dc3545;
                        }

                        .detail-label {
                            font-size: 10px;
                            color: #6c757d;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            margin-bottom: 5px;
                            font-weight: 600;
                        }

                        .detail-value {
                            font-size: 13px;
                            color: #2c3e50;
                            font-weight: 700;
                        }

                        .progress-section {
                            background: white;
                            padding: 0;
                            border-radius: 0;
                            border: none;
                            margin-bottom: 15px;
                        }

                        .progress-header-row {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 15px;
                        }

                        .progress-title-text {
                            font-size: 16px;
                            color: #2c3e50;
                            font-weight: 700;
                        }

                        .progress-badge {
                            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                            color: white;
                            font-size: 28px;
                            font-weight: 700;
                            padding: 10px 25px;
                            border-radius: 12px;
                            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
                            min-width: 120px;
                            text-align: center;
                        }

                        .progress-bar-wrapper {
                            background: #e9ecef;
                            height: 35px;
                            border-radius: 20px;
                            overflow: hidden;
                            margin-bottom: 15px;
                            position: relative;
                            box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
                        }

                        .progress-bar-inner {
                            background: linear-gradient(90deg, #28a745 0%, #34ce57 100%);
                            height: 100%;
                            border-radius: 20px;
                            width: ${progress}%;
                            transition: width 0.6s ease;
                            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.5);
                        }

                        .stats-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 15px;
                            margin-top: 0;
                        }

                        .stat-card {
                            padding: 20px;
                            border-radius: 12px;
                            border-left: 5px solid;
                            position: relative;
                            box-shadow: 0 3px 12px rgba(0,0,0,0.12);
                        }

                        .stat-card.completed {
                            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
                            border-left-color: #28a745;
                        }

                        .stat-card.total {
                            background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
                            border-left-color: #6c757d;
                        }

                        .stat-label {
                            font-size: 11px;
                            font-weight: 700;
                            margin-bottom: 8px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }

                        .stat-card.completed .stat-label {
                            color: #155724;
                        }

                        .stat-card.total .stat-label {
                            color: #495057;
                        }

                        .stat-number {
                            font-size: 36px;
                            font-weight: 700;
                            line-height: 1;
                        }

                        .stat-card.completed .stat-number {
                            color: #28a745;
                        }

                        .stat-card.total .stat-number {
                            color: #495057;
                        }

                        .additional-stats {
                            margin-top: 20px;
                        }

                        .stats-title {
                            display: none;
                        }

                        .additional-stats-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr 1fr 1fr;
                            gap: 12px;
                        }

                        .stat-box {
                            color: white;
                            padding: 20px 15px;
                            border-radius: 12px;
                            text-align: center;
                            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                        }

                        .stat-box-header {
                            font-size: 11px;
                            opacity: 0.95;
                            margin-bottom: 8px;
                            font-weight: 600;
                            text-transform: uppercase;
                        }

                        .stat-box-number {
                            font-size: 32px;
                            font-weight: 700;
                            line-height: 1;
                            margin: 5px 0;
                        }

                        .stat-box-footer {
                            font-size: 10px;
                            opacity: 0.9;
                            margin-top: 5px;
                        }

                        .report-footer {
                            margin-top: 12px;
                            padding-top: 8px;
                            border-top: 2px solid #dee2e6;
                            text-align: center;
                        }

                        .footer-text {
                            color: #6c757d;
                            font-size: 9px;
                            margin-bottom: 3px;
                        }

                        .footer-timestamp {
                            color: #495057;
                            font-size: 8px;
                            font-style: italic;
                        }

                        @media print {
                            body {
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }

                            .page-container {
                                padding: 10mm 15mm;
                            }

                            .no-print {
                                display: none !important;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="page-container">
                        <div class="logo-header">
                            <h1><i class="fas fa-chart-line" style="color: #28a745;"></i> Project Progress Report</h1>
                            <div class="subtitle">Task Completion Analysis</div>
                        </div>

                        <div class="project-header">
                            <h2>${projectName}</h2>
                            <span class="pr-badge">PR# ${prNumber}</span>
                        </div>

                        <div class="project-details">
                            <div class="details-grid">
                                <div class="detail-item customer">
                                    <div class="detail-label"><i class="fas fa-building"></i> Customer</div>
                                    <div class="detail-value">${customer}</div>
                                </div>
                                <div class="detail-item pm">
                                    <div class="detail-label"><i class="fas fa-user-tie"></i> Project Manager</div>
                                    <div class="detail-value">${pm}</div>
                                </div>
                                <div class="detail-item value">
                                    <div class="detail-label"><i class="fas fa-dollar-sign"></i> Project Value</div>
                                    <div class="detail-value">${value} SAR</div>
                                </div>
                                <div class="detail-item po-date">
                                    <div class="detail-label"><i class="fas fa-calendar-alt"></i> PO Date</div>
                                    <div class="detail-value">${poDate}</div>
                                </div>
                            </div>
                        </div>

                        <div class="progress-section">
                            <div class="progress-header-row">
                                <div class="progress-title-text">
                                    <i class="fas fa-chart-line" style="color: #28a745;"></i> Project Progress
                                </div>
                                <div class="progress-badge">${progress}%</div>
                            </div>

                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-inner"></div>
                            </div>

                            <div class="stats-grid">
                                <div class="stat-card completed">
                                    <div class="stat-label">
                                        <i class="fas fa-check-circle"></i> COMPLETED
                                    </div>
                                    <div class="stat-number">${completed}</div>
                                </div>
                                <div class="stat-card total">
                                    <div class="stat-label">
                                        <i class="fas fa-list"></i> TOTAL TASKS
                                    </div>
                                    <div class="stat-number">${total}</div>
                                </div>
                            </div>
                        </div>

                        <div class="additional-stats">
                            <div class="stats-title">
                                <h3><i class="fas fa-chart-bar" style="margin-right: 8px;"></i> Project Statistics</h3>
                            </div>

                            <div class="additional-stats-grid">
                                <div class="stat-box" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);">
                                    <div class="stat-box-header">Assigned To</div>
                                    <div class="stat-box-number" style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto;">
                                        ${assignedNames ? assignedNames.split('|').map(name => '• ' + name).join('<br>') : 'No assignments'}
                                    </div>
                                    <div class="stat-box-footer">${tasksCompleted}/${totalTasksCount} Completed</div>
                                </div>

                                <div class="stat-box" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);">
                                    <div class="stat-box-header">Risk/Issue</div>
                                    <div class="stat-box-number" style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto;">
                                        ${riskNames ? riskNames.split('|').map(risk => '• ' + risk).join('<br>') : 'No risks'}
                                    </div>
                                    <div class="stat-box-footer">${closedRisks}/${totalRisks} Closed</div>
                                </div>

                                <div class="stat-box" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);">
                                    <div class="stat-box-header">Milestone</div>
                                    <div class="stat-box-number" style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto;">
                                        ${milestoneNames ? milestoneNames.split('|').map(milestone => '• ' + milestone).join('<br>') : 'No milestones'}
                                    </div>
                                    <div class="stat-box-footer">${milestonesDone}/${totalMilestones} Done</div>
                                </div>

                                <div class="stat-box" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);">
                                    <div class="stat-box-header">Invoice Number</div>
                                    <div class="stat-box-number" style="font-size: 14px; line-height: 1.6; max-height: 80px; overflow-y: auto;">
                                        ${invoiceNumbers ? invoiceNumbers.split('|').map(invoice => '• ' + invoice).join('<br>') : 'No invoices'}
                                    </div>
                                    <div class="stat-box-footer">${invoicesPaid}/${totalInvoices} Paid</div>
                                </div>
                            </div>
                        </div>

                        <div class="report-footer">
                            <div class="footer-text"><strong>MDSJEDPR</strong> - Corporate Sites Management System</div>
                            <div class="footer-timestamp">Report generated on ${dateStr} at ${timeStr}</div>
                        </div>
                    </div>
                </body>
                </html>
            `;
        }
    </script>
@endsection
