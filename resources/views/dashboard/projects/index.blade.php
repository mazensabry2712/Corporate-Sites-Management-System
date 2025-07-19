@extends('layouts.master')
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
                <h4 class="content-title mb-0 my-auto">Dashboard</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Projects</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <!-- Additional header content can go here -->
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- Display success/error messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main content row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-0">Projects Management</h5>
                        <a class="btn btn-primary" href="{{ route('projects.create') }}">
                            <i class="fas fa-plus"></i> Add New Project
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Actions</th>
                                    <th class="border-bottom-0">PR Number</th>
                                    <th class="border-bottom-0">Project Name</th>
                                    <th class="border-bottom-0">Technologies</th>
                                    <th class="border-bottom-0">Vendor</th>
                                    <th class="border-bottom-0">DS</th>
                                    <th class="border-bottom-0">Customer</th>
                                    <th class="border-bottom-0">Customer PO</th>
                                    <th class="border-bottom-0">Value</th>
                                    <th class="border-bottom-0">AC Manager</th>
                                    <th class="border-bottom-0">Project Manager</th>
                                    <th class="border-bottom-0">Customer Contact</th>
                                    <th class="border-bottom-0">PO Attachment</th>
                                    <th class="border-bottom-0">EPO Attachment</th>
                                    <th class="border-bottom-0">PO Date</th>
                                    <th class="border-bottom-0">Duration (Days)</th>
                                    <th class="border-bottom-0">Deadline</th>
                                    <th class="border-bottom-0">Description</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($projects as $index => $project)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- View Project -->
                                                {{-- <a href="{{ route('projects.show', $project->id) }}"
                                                    class="btn btn-sm btn-info" title="View Project">
                                                    <i class="fas fa-eye"></i>
                                                </a> --}}

                                                @can('Edit')
                                                    <!-- Edit Project -->
                                                    <a href="{{ route('projects.edit', $project->id) }}"
                                                        class="modal-effect btn btn-sm btn-info mr-1" title="Edit Project">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan

                                                {{-- @can('Delete')
                                                    <!-- Delete Project -->
                                                    <button class="modal-effect btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#deleteModal" data-id="{{ $project->id }}"
                                                        data-name="{{ $project->name }}"  title="Delete Project">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                @endcan --}}

@can('Delete')
    <button
        class="btn btn-sm btn-danger"
        data-toggle="modal"
        data-target="#deleteModal"
        data-id="{{ $project->id }}"
        data-name="{{ $project->name }}"
        title="Delete Project"
    >
        <i class="las la-trash"></i>
    </button>
@endcan

                                                {{-- @can('Delete')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-id="{{ $project->id }}" data-name="{{ $project->name }}"
                                                        data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                            class="las la-trash"></i></a>
                                                @endcan --}}




                                            </div>
                                        </td>
                                        <td>{{ $project->pr_number }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->technologies ?? 'N/A' }}</td>
                                        <td>{{ $project->vendor->vendors ?? 'N/A' }}</td>
                                        <td>{{ $project->ds->dsname ?? 'N/A' }}</td>
                                        <td>{{ $project->cust->name ?? 'N/A' }}</td>
                                        <td>{{ $project->customer_po ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->value)
                                                ${{ number_format($project->value, 2) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $project->aams->name ?? 'N/A' }}</td>
                                        <td>{{ $project->ppms->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->customer_contact_details)
                                                <span title="{{ $project->customer_contact_details }}">
                                                    {{ Str::limit($project->customer_contact_details, 30) }}
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($project->po_attachment)
                                                <a href="{{ Storage::url($project->po_attachment) }}"
                                                    class="btn btn-sm btn-outline-primary" title="View PO Attachment"
                                                    target="_blank">
                                                    <i class="fas fa-file"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted">No File</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($project->epo_attachment)
                                                <a href="{{ Storage::url($project->epo_attachment) }}"
                                                    class="btn btn-sm btn-outline-primary" title="View EPO Attachment"
                                                    target="_blank">
                                                    <i class="fas fa-file"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted">No File</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($project->customer_po_date)
                                                {{ \Carbon\Carbon::parse($project->customer_po_date)->format('M d, Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $project->customer_po_duration ?? 'N/A' }}</td>
                                        <td>
                                            @if ($project->customer_po_deadline)
                                                @php
                                                    $deadline = \Carbon\Carbon::parse($project->customer_po_deadline);
                                                    $isOverdue = $deadline->isPast();
                                                @endphp
                                                <span class="{{ $isOverdue ? 'text-danger' : 'text-success' }}">
                                                    {{ $deadline->format('M d, Y') }}
                                                    @if ($isOverdue)
                                                        <i class="fas fa-exclamation-triangle" title="Overdue"></i>
                                                    @endif
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($project->description)
                                                <span title="{{ $project->description }}">
                                                    {{ Str::limit($project->description, 50) }}
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete -->
    {{-- <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="am/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
            </div>
            </form>
        </div>
    </div> --}}


    <!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Confirm Deletion</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('projects.destroy', 0) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p>Are you sure you want to delete this project?</p>
                    <input type="hidden" name="id" id="delete_id">
                    <input type="text" name="name" id="delete_name" class="form-control" readonly>
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
    <!--Internal Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    {{-- <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script> --}}
    <script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')

        var modal = $(this)
        modal.find('#delete_id').val(id)
        modal.find('#delete_name').val(name)

        // تحديث الفورم بالـ route الصحيح (في حالة RESTful)
        let action = '{{ route("projects.destroy", ":id") }}'
        action = action.replace(':id', id)
        $('#deleteForm').attr('action', action)
    })
</script>

@endsection
