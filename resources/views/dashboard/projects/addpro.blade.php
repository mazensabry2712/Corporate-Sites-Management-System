@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Internal DatePicker css -->
    <link href="{{ URL::asset('assets/plugins/jquery-ui/ui/1.12.1/themes/base/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <style>
        .text-info {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .form-text {
            font-size: 0.8rem;
        }

        .select2-container .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #ced4da;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 2px 8px;
            margin: 2px;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #dc3545;
        }

        /* Drag and Drop Styles */
        .drag-drop-area {
            border: 3px dashed #dee2e6;
            border-radius: 12px;
            padding: 30px 15px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            min-height: 160px;
        }

        .drag-drop-area:hover {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .drag-drop-area.dragover {
            border-color: #28a745;
            background-color: #d4edda;
            transform: scale(1.02);
        }

        .drag-drop-content {
            pointer-events: auto;
        }

        .drag-drop-icon {
            margin-bottom: 15px;
        }

        .drag-drop-title {
            color: #495057;
            margin-bottom: 8px;
            font-size: 1.2rem;
        }

        .drag-drop-subtitle {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .browse-link {
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
            pointer-events: auto !important;
            z-index: 10;
            position: relative;
        }

        .file-preview {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-content {
            text-align: center;
            max-width: 90%;
        }

        .preview-image {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }

        .preview-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .file-name {
            font-weight: bold;
            color: #495057;
            font-size: 0.9rem;
        }

        .file-size {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .remove-file {
            margin-top: 8px;
        }

        .file-icon-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .file-icon-preview i {
            color: #007bff;
        }
    </style>
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

                            <!-- Vendors (Multiple Selection) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vendors">Vendors <span class="text-info">*Multiple Selection</span></label>
                                    <select class="form-control select2-multiple @error('vendors') is-invalid @enderror"
                                            id="vendors" name="vendors[]" multiple>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ in_array($vendor->id, old('vendors', [])) ? 'selected' : '' }}>
                                                {{ $vendor->vendors }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select one or more vendors. First selected will be primary.</small>
                                    @error('vendors')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('vendors_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Delivery Specialists (Multiple Selection) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="delivery_specialists">Delivery Specialists <span class="text-info">*Multiple Selection</span></label>
                                    <select class="form-control select2-multiple @error('delivery_specialists') is-invalid @enderror"
                                            id="delivery_specialists" name="delivery_specialists[]" multiple>
                                        @foreach($ds as $dsItem)
                                            <option value="{{ $dsItem->id }}" {{ in_array($dsItem->id, old('delivery_specialists', [])) ? 'selected' : '' }}>
                                                {{ $dsItem->dsname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select one or more DS. First selected will be lead.</small>
                                    @error('delivery_specialists')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('ds_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Customers (Multiple Selection) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customers">Customers <span class="text-info">*Multiple Selection</span></label>
                                    <select class="form-control select2-multiple @error('customers') is-invalid @enderror"
                                            id="customers" name="customers[]" multiple>
                                        @foreach($custs as $cust)
                                            <option value="{{ $cust->id }}" {{ in_array($cust->id, old('customers', [])) ? 'selected' : '' }}>
                                                {{ $cust->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select one or more customers. First selected will be primary.</small>
                                    @error('customers')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <div class="drag-drop-area" id="dragDropAreaPO" onclick="if(!event.target.closest('.file-preview') && !event.target.classList.contains('remove-file')) { document.getElementById('po_attachment').click(); }">
                                        <input type="file" name="po_attachment" id="po_attachment" class="d-none @error('po_attachment') is-invalid @enderror"
                                            accept=".pdf,.jpg,.jpeg,.png" />

                                        <div class="drag-drop-content">
                                            <div class="drag-drop-icon">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                                            </div>
                                            <h5 class="drag-drop-title">Drag & Drop PO File</h5>
                                            <p class="drag-drop-subtitle">or <span class="browse-link" onclick="document.getElementById('po_attachment').click();">click to browse</span></p>
                                            <small class="text-muted">PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                                        </div>

                                        <div class="file-preview d-none">
                                            <div class="preview-content">
                                                <div class="file-icon-preview">
                                                    <img class="preview-image d-none" src="" alt="Preview">
                                                    <i class="fas fa-file-alt fa-3x d-none file-icon"></i>
                                                    <div class="preview-info">
                                                        <span class="file-name"></span>
                                                        <span class="file-size"></span>
                                                        <button type="button" class="btn btn-sm btn-danger remove-file">
                                                            <i class="fas fa-times"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('po_attachment')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- EPO Attachment -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="epo_attachment">EPO Attachment</label>
                                    <div class="drag-drop-area" id="dragDropAreaEPO" onclick="if(!event.target.closest('.file-preview') && !event.target.classList.contains('remove-file')) { document.getElementById('epo_attachment').click(); }">
                                        <input type="file" name="epo_attachment" id="epo_attachment" class="d-none @error('epo_attachment') is-invalid @enderror"
                                            accept=".pdf,.jpg,.jpeg,.png" />

                                        <div class="drag-drop-content">
                                            <div class="drag-drop-icon">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-success"></i>
                                            </div>
                                            <h5 class="drag-drop-title">Drag & Drop EPO File</h5>
                                            <p class="drag-drop-subtitle">or <span class="browse-link" onclick="document.getElementById('epo_attachment').click();">click to browse</span></p>
                                            <small class="text-muted">PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                                        </div>

                                        <div class="file-preview d-none">
                                            <div class="preview-content">
                                                <div class="file-icon-preview">
                                                    <img class="preview-image d-none" src="" alt="Preview">
                                                    <i class="fas fa-file-alt fa-3x d-none file-icon"></i>
                                                    <div class="preview-info">
                                                        <span class="file-name"></span>
                                                        <span class="file-size"></span>
                                                        <button type="button" class="btn btn-sm btn-success remove-file">
                                                            <i class="fas fa-times"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('epo_attachment')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
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

                        <!-- Hidden fields for backward compatibility -->
                        <input type="hidden" id="vendors_id" name="vendors_id">
                        <input type="hidden" id="ds_id" name="ds_id">
                        <input type="hidden" id="cust_id" name="cust_id">

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
            // Initialize Select2 for single selection
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });

            // Initialize Select2 for multiple selection
            $('.select2-multiple').select2({
                placeholder: "Select multiple options",
                allowClear: true,
                closeOnSelect: false
            });

            // Auto-update hidden fields when multiple selections change
            $('#vendors').on('change', function() {
                var selected = $(this).val();
                if (selected && selected.length > 0) {
                    $('#vendors_id').val(selected[0]); // First selected becomes primary
                } else {
                    $('#vendors_id').val('');
                }
            });

            $('#delivery_specialists').on('change', function() {
                var selected = $(this).val();
                if (selected && selected.length > 0) {
                    $('#ds_id').val(selected[0]); // First selected becomes lead
                } else {
                    $('#ds_id').val('');
                }
            });

            $('#customers').on('change', function() {
                var selected = $(this).val();
                if (selected && selected.length > 0) {
                    $('#cust_id').val(selected[0]); // First selected becomes primary
                } else {
                    $('#cust_id').val('');
                }
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

            // Drag and Drop functionality for PO Attachment
            setupDragDrop('dragDropAreaPO', 'po_attachment');

            // Drag and Drop functionality for EPO Attachment
            setupDragDrop('dragDropAreaEPO', 'epo_attachment');

            function setupDragDrop(areaId, inputId) {
                const dragDropArea = $('#' + areaId);
                const fileInput = $('#' + inputId);
                const dragDropContent = dragDropArea.find('.drag-drop-content');
                const filePreview = dragDropArea.find('.file-preview');

                // Drag and drop events
                dragDropArea.on('dragover dragenter', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass('dragover');
                });

                dragDropArea.on('dragleave dragend', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('dragover');
                });

                dragDropArea.on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('dragover');

                    const files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        handleFiles(files, inputId, areaId);
                    }
                });

                // File input change event
                fileInput.on('change', function() {
                    if (this.files.length > 0) {
                        handleFiles(this.files, inputId, areaId);
                    }
                });

                // Remove file button
                dragDropArea.on('click', '.remove-file', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    removeFile(inputId, areaId);
                });
            }

            function handleFiles(files, inputId, areaId) {
                const file = files[0];
                const dragDropArea = $('#' + areaId);
                const fileInput = $('#' + inputId);

                // Validate file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid file (PDF, JPG, JPEG, PNG)');
                    return;
                }

                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    return;
                }

                // Set file to input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput[0].files = dt.files;

                // Show preview
                showPreview(file, areaId);
            }

            function showPreview(file, areaId) {
                const dragDropArea = $('#' + areaId);
                const dragDropContent = dragDropArea.find('.drag-drop-content');
                const filePreview = dragDropArea.find('.file-preview');

                // Check if it's an image
                const isImage = file.type.startsWith('image/');

                if (isImage) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.find('.preview-image').attr('src', e.target.result).removeClass('d-none');
                        filePreview.find('.file-icon').addClass('d-none');
                        filePreview.find('.file-name').text(file.name);
                        filePreview.find('.file-size').text(formatFileSize(file.size));

                        dragDropContent.addClass('d-none');
                        filePreview.removeClass('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Show file icon for non-images (PDF)
                    filePreview.find('.preview-image').addClass('d-none');
                    filePreview.find('.file-icon').removeClass('d-none');
                    filePreview.find('.file-name').text(file.name);
                    filePreview.find('.file-size').text(formatFileSize(file.size));

                    dragDropContent.addClass('d-none');
                    filePreview.removeClass('d-none');
                }
            }

            function removeFile(inputId, areaId) {
                const dragDropArea = $('#' + areaId);
                const fileInput = $('#' + inputId);
                const dragDropContent = dragDropArea.find('.drag-drop-content');
                const filePreview = dragDropArea.find('.file-preview');

                fileInput.val('');
                filePreview.addClass('d-none');
                dragDropContent.removeClass('d-none');

                // Reset preview elements
                filePreview.find('.preview-image').attr('src', '').addClass('d-none');
                filePreview.find('.file-icon').addClass('d-none');
                filePreview.find('.file-name').text('');
                filePreview.find('.file-size').text('');
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
@endsection
