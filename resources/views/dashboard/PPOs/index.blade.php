@extends('layouts.master')

@section('title')
    PPOs Management
@stop

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">General</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    PPOs Management</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    @can('Add')
                        <a class="btn btn-outline-primary btn-block" href="{{ route('ppos.create') }}"> Add PPO </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operations</th>
                                    <th>Project Number</th>
                                    <th>Category</th>
                                    <th>Supplier Name</th>
                                    <th>PO Number</th>
                                    <th>Value</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Updates</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($ppos as $x)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            @can('Edit')
                                                <a class="btn btn-sm btn-info" href="{{ route('ppos.edit', $x->id) }}"
                                                    title="Update"><i class="las la-pen"></i></a>
                                            @endcan

                                            @can('Delete')
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $x->id }}" data-name="{{ $x->po_number }}"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="las la-trash"></i></a>
                                            @endcan
                                        </td>
                                        <td>{{ $x->project->pr_number ?? 'N/A' }}</td>
                                        <td>{{ $x->pepo->category ?? 'N/A' }}</td>
                                        <td>{{ $x->ds->dsname ?? 'N/A' }}</td>
                                        <td>{{ $x->po_number }}</td>
                                        <td>
                                            @if($x->value)
                                                ${{ number_format($x->value, 2) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $x->date ? $x->date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($x->status) {
                                                    'Active' => 'success',
                                                    'Pending' => 'warning',
                                                    'Completed' => 'info',
                                                    'Cancelled' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $statusClass }}">{{ $x->status ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $x->updates ?? 'No updates' }}</td>
                                        <td>{{ $x->notes ?? 'No notes' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete PPO</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ url('ppos/destroy') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
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
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>
@endsection
