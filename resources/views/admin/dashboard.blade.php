@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <style>
        .sales-card {
            border-radius: 15px !important;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }

        .sales-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
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
                {{-- <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span> --}}
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">

    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">

    </div>
    <!-- row close -->

    <!-- row opened -->
    <div class="row row-sm row-deck">

    </div>
    <!-- /row -->
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
@endsection
