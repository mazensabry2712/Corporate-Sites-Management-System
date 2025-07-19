@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Internal DatePicker css -->
    <link href="{{ URL::asset('assets/plugins/jquery-ui/ui/1.12.1/themes/base/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Dashboard</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Projects / Add New Project</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main content row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-0">Add New Project</h5>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- PR Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pr_number">PR Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('pr_number') is-invalid @enderror"
                                           id="pr_number" name="pr_number" value="{{ old('pr_number') }}" required>
                                    @error('pr_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Project Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Technologies -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="technologies">Technologies</label>
                                    <input type="text" class="form-control @error('technologies') is-invalid @enderror"
                                           id="technologies" name="technologies" value="{{ old('technologies') }}">
                                    @error('technologies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Vendor -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vendors_id">Vendor</label>
                                    <select class="form-control select2 @error('vendors_id') is-invalid @enderror"
                                            id="vendors_id" name="vendors_id">
                                        <option value="">Select Vendor</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ old('vendors_id') == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->vendors }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vendors_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- DS -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ds_id">DS</label>
                                    <select class="form-control select2 @error('ds_id') is-invalid @enderror"
                                            id="ds_id" name="ds_id">
                                        <option value="">Select DS</option>
                                        @foreach($ds as $dsItem)
                                            <option value="{{ $dsItem->id }}" {{ old('ds_id') == $dsItem->id ? 'selected' : '' }}>
                                                {{ $dsItem->dsname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ds_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Customer -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cust_id">Customer</label>
                                    <select class="form-control select2 @error('cust_id') is-invalid @enderror"
                                            id="cust_id" name="cust_id">
                                        <option value="">Select Customer</option>
                                        @foreach($custs as $cust)
                                            <option value="{{ $cust->id }}" {{ old('cust_id') == $cust->id ? 'selected' : '' }}>
                                                {{ $cust->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cust_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Customer PO -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_po">Customer PO</label>
                                    <input type="text" class="form-control @error('customer_po') is-invalid @enderror"
                                           id="customer_po" name="customer_po" value="{{ old('customer_po') }}">
                                    @error('customer_po')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Value -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror"
                                           id="value" name="value" value="{{ old('value') }}">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- AC Manager -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aams_id">AC Manager</label>
                                    <select class="form-control select2 @error('aams_id') is-invalid @enderror"
                                            id="aams_id" name="aams_id">
                                        <option value="">Select AC Manager</option>
                                        @foreach($aams as $aam)
                                            <option value="{{ $aam->id }}" {{ old('aams_id') == $aam->id ? 'selected' : '' }}>
                                                {{ $aam->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aams_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Project Manager -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ppms_id">Project Manager</label>
                                    <select class="form-control select2 @error('ppms_id') is-invalid @enderror"
                                            id="ppms_id" name="ppms_id">
                                        <option value="">Select Project Manager</option>
                                        @foreach($ppms as $ppm)
                                            <option value="{{ $ppm->id }}" {{ old('ppms_id') == $ppm->id ? 'selected' : '' }}>
                                                {{ $ppm->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ppms_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Customer Contact Details -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="customer_contact_details">Customer Contact Details</label>
                                    <textarea class="form-control @error('customer_contact_details') is-invalid @enderror"
                                              id="customer_contact_details" name="customer_contact_details" rows="3">{{ old('customer_contact_details') }}</textarea>
                                    @error('customer_contact_details')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- PO Date -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_po_date">PO Date</label>
                                    <input type="date" class="form-control @error('customer_po_date') is-invalid @enderror"
                                           id="customer_po_date" name="customer_po_date" value="{{ old('customer_po_date') }}">
                                    @error('customer_po_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration (Days) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_po_duration">Duration (Days)</label>
                                    <input type="number" class="form-control @error('customer_po_duration') is-invalid @enderror"
                                           id="customer_po_duration" name="customer_po_duration" value="{{ old('customer_po_duration') }}">
                                    @error('customer_po_duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deadline -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_po_deadline">Deadline</label>
                                    <input type="date" class="form-control @error('customer_po_deadline') is-invalid @enderror"
                                           id="customer_po_deadline" name="customer_po_deadline" value="{{ old('customer_po_deadline') }}">
                                    @error('customer_po_deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- PO Attachment -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_attachment">PO Attachment</label>
                                    <input type="file" class="form-control-file @error('po_attachment') is-invalid @enderror"
                                           id="po_attachment" name="po_attachment" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Allowed formats: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                                    @error('po_attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- EPO Attachment -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="epo_attachment">EPO Attachment</label>
                                    <input type="file" class="form-control-file @error('epo_attachment') is-invalid @enderror"
                                           id="epo_attachment" name="epo_attachment" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Allowed formats: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                                    @error('epo_attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Description -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Project
                            </button>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });

            // Calculate deadline based on PO date and duration
            $('#customer_po_date, #customer_po_duration').on('change', function() {
                var poDate = $('#customer_po_date').val();
                var duration = $('#customer_po_duration').val();

                if (poDate && duration) {
                    var date = new Date(poDate);
                    date.setDate(date.getDate() + parseInt(duration));

                    var deadline = date.toISOString().split('T')[0];
                    $('#customer_po_deadline').val(deadline);
                }
            });
        });
    </script>
@endsection
