@extends('layouts.master')

@section('title')
    Edit PPO
@stop

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    PPOs Management / Edit PPO</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ppos.index') }}">Back</a>
                        </div>
                    </div><br>

                    <form action="{{ route('ppos.update', $ppo->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Project Number: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="pr_number" required>
                                        <option value="">Choose Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ (old('pr_number', $ppo->pr_number) == $project->id) ? 'selected' : '' }}>
                                                {{ $project->pr_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="form-label">Category: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="category" required>
                                        <option value="">Choose Category</option>
                                        @foreach($pepos as $pepo)
                                            <option value="{{ $pepo->id }}"
                                                {{ (old('category', $ppo->category) == $pepo->id) ? 'selected' : '' }}>
                                                {{ $pepo->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dsname" class="form-label">Supplier Name: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="dsname" required>
                                        <option value="">Choose Supplier</option>
                                        @foreach($dses as $ds)
                                            <option value="{{ $ds->id }}"
                                                {{ (old('dsname', $ppo->dsname) == $ds->id) ? 'selected' : '' }}>
                                                {{ $ds->dsname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_number" class="form-label">PO Number: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" id="po_number" name="po_number"
                                           value="{{ old('po_number', $ppo->po_number) }}" placeholder="Enter PO Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value" class="form-label">Value:</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="value" name="value"
                                           value="{{ old('value', $ppo->value) }}" placeholder="Enter Value">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date:</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                           value="{{ old('date', $ppo->date ? $ppo->date->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Choose Status</option>
                                        <option value="Active" {{ old('status', $ppo->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Pending" {{ old('status', $ppo->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ old('status', $ppo->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ old('status', $ppo->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="updates" class="form-label">Updates:</label>
                                    <textarea class="form-control" id="updates" name="updates" rows="3"
                                              placeholder="Enter updates">{{ old('updates', $ppo->updates) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes" class="form-label">Notes:</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"
                                              placeholder="Enter notes">{{ old('notes', $ppo->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mg-t-30">
                            <button class="btn btn-primary pd-x-20" type="submit">Update PPO</button>
                            <a href="{{ route('ppos.index') }}" class="btn btn-secondary pd-x-20">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
