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
            box-shadow: 0 5px 20px rgba(0,0,0,0.12) !important;
            margin-bottom: 20px;
        }

        .sales-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 12px 35px rgba(0,0,0,0.2) !important;
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
            0%, 100% {
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
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $invoiceCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $dnCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $cocCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $posCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $statusCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $tasksCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $epoCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $reskCount }}</h4>
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
                                    <h4 class="tx-18 font-weight-bold mb-0 text-white stats-number">{{ $milestonesCount }}</h4>
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
                            <div class="form-group">
                                <label><i class="fas fa-briefcase"></i> Project Name</label>
                                <select name="filter[project]" class="form-control select2" data-placeholder="-- Select Project --">
                                    <option></option>
                                    <option value="all" {{ request('filter.project') == 'all' ? 'selected' : '' }}>All Projects ({{ $projectcount }})</option>
                                    @foreach($projectNames as $projectName)
                                        <option value="{{ $projectName }}" {{ request('filter.project') == $projectName ? 'selected' : '' }}>
                                            {{ $projectName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-tasks"></i> Project Status</label>
                                <select name="filter[status]" class="form-control select2" data-placeholder="-- Select Status --">
                                    <option></option>
                                    <option value="active" {{ request('filter.status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ request('filter.status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request('filter.status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 2: Team & Resources --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#teamResources">
                        <h6>
                            <span><i class="fas fa-users"></i> Team & Resources</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="teamResources" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-user-tie"></i> Project Manager</label>
                                <select name="filter[pm]" class="form-control select2" data-placeholder="-- Select PM --">
                                    <option></option>
                                    <option value="all" {{ request('filter.pm') == 'all' ? 'selected' : '' }}>All PMs ({{ $pmCount }})</option>
                                    @foreach($projectManagers as $pm)
                                        <option value="{{ $pm }}" {{ request('filter.pm') == $pm ? 'selected' : '' }}>
                                            {{ $pm }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-user-cog"></i> Account Manager</label>
                                <select name="filter[am]" class="form-control select2" data-placeholder="-- Select AM --">
                                    <option></option>
                                    <option value="all" {{ request('filter.am') == 'all' ? 'selected' : '' }}>All AMs ({{ $amCount }})</option>
                                    @foreach($accountManagers as $am)
                                        <option value="{{ $am }}" {{ request('filter.am') == $am ? 'selected' : '' }}>
                                            {{ $am }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-handshake"></i> Customer</label>
                                <select name="filter[customer]" class="form-control select2" data-placeholder="-- Select Customer --">
                                    <option></option>
                                    <option value="all" {{ request('filter.customer') == 'all' ? 'selected' : '' }}>All Customers ({{ $custCount }})</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer }}" {{ request('filter.customer') == $customer ? 'selected' : '' }}>
                                            {{ $customer }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 3: Financial & Documents --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#financial">
                        <h6>
                            <span><i class="fas fa-dollar-sign"></i> Financial & Documents</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="financial" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-receipt"></i> Invoice Status</label>
                                <select name="filter[invoice_status]" class="form-control select2" data-placeholder="-- Select Status --">
                                    <option></option>
                                    <option value="paid">Paid</option>
                                    <option value="pending">Pending</option>
                                    <option value="overdue">Overdue</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-file-contract"></i> PO Status</label>
                                <select name="filter[po_status]" class="form-control select2" data-placeholder="-- Select Status --">
                                    <option></option>
                                    <option value="active">Active ({{ $posCount }})</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 4: Tasks & Milestones --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#tasksMilestones">
                        <h6>
                            <span><i class="fas fa-clipboard-check"></i> Tasks & Milestones</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="tasksMilestones" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-clipboard-list"></i> Task Status</label>
                                <select name="filter[task_status]" class="form-control select2" data-placeholder="-- Select Status --">
                                    <option></option>
                                    <option value="completed" {{ request('filter.task_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ request('filter.task_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="progress" {{ request('filter.task_status') == 'progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="hold" {{ request('filter.task_status') == 'hold' ? 'selected' : '' }}>On Hold</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-flag-checkered"></i> Milestones</label>
                                <select name="filter[milestone]" class="form-control select2" data-placeholder="-- Select Milestone --">
                                    <option></option>
                                    <option value="on track" {{ request('filter.milestone') == 'on track' ? 'selected' : '' }}>On Track</option>
                                    <option value="delayed" {{ request('filter.milestone') == 'delayed' ? 'selected' : '' }}>Delayed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter 5: Risk Management --}}
                <div class="card filter-card">
                    <div class="card-header" data-toggle="collapse" data-target="#riskManagement">
                        <h6>
                            <span><i class="fas fa-exclamation-triangle"></i> Risk Management</span>
                            <i class="fas fa-chevron-up toggle-icon"></i>
                        </h6>
                    </div>
                    <div id="riskManagement" class="collapse show">
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fas fa-thermometer-half"></i> Risk Level</label>
                                <select name="filter[risk_level]" class="form-control select2" data-placeholder="-- Select Level --">
                                    <option></option>
                                    <option value="low" {{ request('filter.risk_level') == 'low' ? 'selected' : '' }}>Low Risk</option>
                                    <option value="med" {{ request('filter.risk_level') == 'med' ? 'selected' : '' }}>Medium Risk</option>
                                    <option value="high" {{ request('filter.risk_level') == 'high' ? 'selected' : '' }}>High Risk</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-shield-alt"></i> Risk Status</label>
                                <select name="filter[risk_status]" class="form-control select2" data-placeholder="-- Select Status --">
                                    <option></option>
                                    <option value="open" {{ request('filter.risk_status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ request('filter.risk_status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
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
            @if($hasFilters)
                {{-- Filtered Results --}}
                <div class="row row-sm">
                    {{-- Projects Results --}}
                    @if($filteredProjects)
                        <div class="col-12 mb-4">
                            <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 123, 255, 0.15);">
                                <div class="card-header" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                                    <h4 class="card-title text-white mb-0">
                                        <i class="fas fa-project-diagram"></i> Filtered Projects
                                        <span class="badge badge-light ml-2">{{ $filteredProjects->count() }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @if($filteredProjects->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <th>Customer</th>
                                                        <th>PM</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($filteredProjects as $project)
                                                        <tr>
                                                            <td><strong>{{ $project->name }}</strong></td>
                                                            <td>{{ $project->cust->name ?? 'N/A' }}</td>
                                                            <td>{{ $project->ppms->name ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge badge-primary">{{ $project->latestStatus->status ?? 'No Status' }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-center text-muted">No projects found matching your filters</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Tasks Results Table --}}
                    <div class="col-12 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(40, 167, 69, 0.15);">
                            <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);">
                                <h4 class="card-title text-white mb-0">
                                    <i class="fas fa-clipboard-list"></i> Filtered Tasks
                                    <span class="badge badge-light ml-2">{{ $filteredTasks ? $filteredTasks->count() : 0 }}</span>
                                </h4>
                            </div>
                            <div class="card-body">
                                @if($filteredTasks && $filteredTasks->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead style="background: #f8f9fa;">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 35%;">Task Details</th>
                                                    <th style="width: 20%;">Assigned To</th>
                                                    <th style="width: 20%;">Expected Date</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 10%;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($filteredTasks as $index => $task)
                                                    <tr>
                                                        <td><strong>{{ $index + 1 }}</strong></td>
                                                        <td>{{ $task->details ?? 'Task #' . $task->id }}</td>
                                                        <td>
                                                            @if($task->assigned)
                                                                <i class="fas fa-user"></i> {{ $task->assigned }}
                                                            @else
                                                                <span class="text-muted">Unassigned</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($task->expected_com_date)
                                                                <i class="far fa-calendar"></i> {{ $task->expected_com_date }}
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $task->status == 'completed' ? 'success' : ($task->status == 'pending' ? 'warning' : ($task->status == 'hold' ? 'danger' : 'info')) }}">
                                                                {{ ucfirst($task->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" title="View Details">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-clipboard-list" style="font-size: 4rem; color: #28a745; opacity: 0.3;"></i>
                                        <h5 class="mt-4 text-muted">No tasks found matching the filters</h5>
                                        <p class="text-muted">Try adjusting your filter criteria</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Milestones Results Table --}}
                    <div class="col-12 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(255, 193, 7, 0.15);">
                            <div class="card-header" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);">
                                <h4 class="card-title text-white mb-0">
                                    <i class="fas fa-flag-checkered"></i> Filtered Milestones
                                    <span class="badge badge-light ml-2">{{ $filteredMilestones ? $filteredMilestones->count() : 0 }}</span>
                                </h4>
                            </div>
                            <div class="card-body">
                                @if($filteredMilestones && $filteredMilestones->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead style="background: #f8f9fa;">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 35%;">Milestone</th>
                                                    <th style="width: 20%;">Planned Date</th>
                                                    <th style="width: 20%;">Actual Date</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 10%;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($filteredMilestones as $index => $milestone)
                                                    <tr>
                                                        <td><strong>{{ $index + 1 }}</strong></td>
                                                        <td>{{ $milestone->milestone ?? 'Milestone #' . $milestone->id }}</td>
                                                        <td>
                                                            @if($milestone->planned_com)
                                                                <i class="far fa-calendar"></i> {{ $milestone->planned_com }}
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($milestone->actual_com)
                                                                <i class="far fa-calendar-check"></i> {{ $milestone->actual_com }}
                                                            @else
                                                                <span class="text-muted">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $milestone->status == 'on track' ? 'success' : 'warning' }}">
                                                                {{ ucfirst($milestone->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" title="View Details">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-flag-checkered" style="font-size: 4rem; color: #ffc107; opacity: 0.3;"></i>
                                        <h5 class="mt-4 text-muted">No milestones found matching the filters</h5>
                                        <p class="text-muted">Try adjusting your filter criteria</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Invoices Results Table --}}
                    <div class="col-12 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(23, 162, 184, 0.15);">
                            <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                                <h4 class="card-title text-white mb-0">
                                    <i class="fas fa-file-invoice-dollar"></i> Filtered Invoices
                                    <span class="badge badge-light ml-2">{{ $filteredInvoices ? $filteredInvoices->count() : 0 }}</span>
                                </h4>
                            </div>
                            <div class="card-body">
                                @if($filteredInvoices && $filteredInvoices->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead style="background: #f8f9fa;">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 20%;">Invoice Number</th>
                                                    <th style="width: 20%;">Value</th>
                                                    <th style="width: 15%;">Status</th>
                                                    <th style="width: 25%;">Total PR Value</th>
                                                    <th style="width: 15%;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($filteredInvoices as $index => $invoice)
                                                    <tr>
                                                        <td><strong>{{ $index + 1 }}</strong></td>
                                                        <td>{{ $invoice->invoice_number }}</td>
                                                        <td><strong class="text-success">${{ number_format($invoice->value, 2) }}</strong></td>
                                                        <td>
                                                            <span class="badge badge-info">{{ $invoice->status ?? 'Pending' }}</span>
                                                        </td>
                                                        <td>
                                                            @if($invoice->pr_invoices_total_value)
                                                                ${{ number_format($invoice->pr_invoices_total_value, 2) }}
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" title="View Invoice">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-success" title="Download">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-file-invoice-dollar" style="font-size: 4rem; color: #17a2b8; opacity: 0.3;"></i>
                                        <h5 class="mt-4 text-muted">No invoices found matching the filters</h5>
                                        <p class="text-muted">Try adjusting your filter criteria</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Risks Results Table --}}
                    <div class="col-12 mb-4">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(220, 53, 69, 0.15);">
                            <div class="card-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                                <h4 class="card-title text-white mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> Filtered Risks
                                    <span class="badge badge-light ml-2">{{ $filteredRisks ? $filteredRisks->count() : 0 }}</span>
                                </h4>
                            </div>
                            <div class="card-body">
                                @if($filteredRisks && $filteredRisks->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead style="background: #f8f9fa;">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 30%;">Risk Description</th>
                                                    <th style="width: 15%;">Impact</th>
                                                    <th style="width: 15%;">Owner</th>
                                                    <th style="width: 20%;">Mitigation</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 5%;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($filteredRisks as $index => $risk)
                                                    <tr>
                                                        <td><strong>{{ $index + 1 }}</strong></td>
                                                        <td>{{ $risk->risk }}</td>
                                                        <td>
                                                            <span class="badge badge-{{ $risk->impact == 'high' ? 'danger' : ($risk->impact == 'med' ? 'warning' : 'success') }}">
                                                                {{ strtoupper($risk->impact) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $risk->owner ?? 'Unassigned' }}</td>
                                                        <td>
                                                            <small>{{ $risk->mitigation ? Str::limit($risk->mitigation, 50) : 'N/A' }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $risk->status == 'open' ? 'danger' : 'success' }}">
                                                                {{ ucfirst($risk->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" title="View Details">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: #dc3545; opacity: 0.3;"></i>
                                        <h5 class="mt-4 text-muted">No risks found matching the filters</h5>
                                        <p class="text-muted">Try adjusting your filter criteria</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Statistics Summary --}}
                    <div class="col-12">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 123, 255, 0.15);">
                            <div class="card-header" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                                <h4 class="card-title text-white mb-0">
                                    <i class="fas fa-chart-bar"></i> Filtered Statistics Summary
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="p-3">
                                            <h2 class="text-primary">{{ $filteredProjects ? $filteredProjects->count() : 0 }}</h2>
                                            <p class="text-muted mb-0">Projects</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3">
                                            <h2 class="text-success">{{ $filteredTasks ? $filteredTasks->count() : 0 }}</h2>
                                            <p class="text-muted mb-0">Tasks</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3">
                                            <h2 class="text-warning">{{ $filteredMilestones ? $filteredMilestones->count() : 0 }}</h2>
                                            <p class="text-muted mb-0">Milestones</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3">
                                            <h2 class="text-danger">{{ $filteredRisks ? $filteredRisks->count() : 0 }}</h2>
                                            <p class="text-muted mb-0">Risks</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- No Filters Applied --}}
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="card" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 123, 255, 0.15);">
                            <div class="card-header" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 15px 15px 0 0;">
                                <h4 class="card-title text-white mb-0">
                                    <i class="fas fa-chart-line"></i> Filtered Dashboard Data
                                </h4>
                            </div>
                            <div class="card-body" style="min-height: 400px;">
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-bar" style="font-size: 4rem; color: #007bff; opacity: 0.3;"></i>
                                    <h5 class="mt-4" style="color: #6c757d;">Apply filters to view customized data</h5>
                                    <p class="text-muted">Use the filters on the left to narrow down your dashboard view</p>
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
            window.location.href = '{{ route("dashboard.index") }}';
        }

        // Form submission with loading indicator
        $('#filterForm').on('submit', function(e) {
            // Show loading state
            $('.btn-apply-filter').html('<i class="fas fa-spinner fa-spin"></i> Applying...').prop('disabled', true);
        });

        // Collapse all filters function
        function collapseAllFilters() {
            $('.collapse').collapse('hide');
        }

        // Expand all filters function
        function expandAllFilters() {
            $('.collapse').collapse('show');
        }
    </script>
@endsection
