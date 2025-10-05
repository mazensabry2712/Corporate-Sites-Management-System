
@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endsection

@section('title')
    Edit Project Status
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add pstatus </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    pstatus</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="yourFormId" action="{{ route('pstatus.update',$pstatus->id) }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        {{-- 1 --}}


                        <div class="row mt-3">
                            <div class="col">
                                <label for="pr_number" class="control-label">PR Number: <span class="tx-danger">*</span></label>
                                <select name="pr_number" id="pr_number" class="form-control SlectBox" required>
                                    <option value="">Choose PR Number</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" data-project-name="{{ $project->name }}"
                                            {{ (old('pr_number', $pstatus->pr_number) == $project->id) ? 'selected' : '' }}>
                                            {{ $project->pr_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label class="control-label">Project Name:</label>
                                <input type="text" id="project_name_display" class="form-control" readonly
                                       style="background-color: #f8f9fa; cursor: not-allowed;">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="date_time" class="control-label">Date & Time:</label>
                                <input type="date" class="form-control" id="date_time" name="date_time"
                                       value="{{ old('date_time', $pstatus->date_time) }}">
                                <small class="text-muted">Auto filled once the update is sent</small>
                            </div>

                            <div class="col">
                                <label for="pm_name" class="control-label">PM Name: <span class="tx-danger">*</span></label>
                                <select name="pm_name" class="form-control SlectBox" required>
                                    <option value="">Choose PM Name</option>
                                    @foreach ($ppms as $ppm)
                                        <option value="{{ $ppm->id }}"
                                            {{ (old('pm_name', $pstatus->pm_name) == $ppm->id) ? 'selected' : '' }}>
                                            {{ $ppm->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Taken from login name and PM details</small>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="status" class="control-label">Status:</label>
                                <textarea class="form-control" id="status" name="status" rows="4"
                                          placeholder="Enter project status...">{{ old('status', $pstatus->status) }}</textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="actual_completion" class="control-label">Actual Completion %:</label>
                                <input type="number" class="form-control" id="actual_completion"
                                       name="actual_completion" min="0" max="100" step="0.01"
                                       value="{{ old('actual_completion', $pstatus->actual_completion) }}"
                                       placeholder="Enter percentage (0-100)">
                            </div>

                            <div class="col-md-4">
                                <label for="expected_completion" class="control-label">Expected Completion Date:</label>
                                <input type="date" class="form-control" id="expected_completion"
                                       name="expected_completion"
                                       value="{{ old('expected_completion', $pstatus->expected_completion) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="date_pending_cost_orders" class="control-label">Pending Cost/Orders:</label>
                                <input type="text" class="form-control" id="date_pending_cost_orders"
                                       name="date_pending_cost_orders"
                                       value="{{ old('date_pending_cost_orders', $pstatus->date_pending_cost_orders) }}"
                                       placeholder="Enter pending costs or orders">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="notes" class="control-label">Notes:</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4"
                                          placeholder="Enter additional notes...">{{ old('notes', $pstatus->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="mg-t-30">
                            <button class="btn btn-outline-primary pd-x-20" type="submit">Update Project Status</button>
                            <a href="{{ route('pstatus.index') }}" class="btn btn-outline-secondary pd-x-20">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Auto-fill project name when PR Number changes
            $('#pr_number').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const projectName = selectedOption.data('project-name');

                if (projectName) {
                    $('#project_name_display').val(projectName).css('color', '#495057');
                } else {
                    $('#project_name_display').val('No project name available').css('color', '#6c757d');
                }
            });

            // Initialize on page load with current value
            if ($('#pr_number').val()) {
                $('#pr_number').trigger('change');
            }
        });
    </script>
@endsection
