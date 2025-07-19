@extends('layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Dashboard</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Certificate of Compliance</span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn btn-secondary" href="{{ route('coc.index') }}">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Certificate of Compliance</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('coc.update', $coc->id) }}" method="post" enctype="multipart/form-data">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pr_number">Project <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="pr_number" id="pr_number" required>
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ (old('pr_number') ?? $coc->pr_number) == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pr_number')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="coc_copy">CoC File</label>

                                    @if($coc->coc_copy)
                                        <div class="mb-3">
                                            <div class="alert alert-info">
                                                <strong>Current File:</strong>
                                                <a href="{{ asset('storage/' . $coc->coc_copy) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary ml-2">
                                                    <i class="fas fa-eye"></i> View Current File
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('coc_copy') is-invalid @enderror"
                                               id="coc_copy"
                                               name="coc_copy"
                                               accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                                        <label class="custom-file-label" for="coc_copy">Choose new file (optional)...</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Leave empty to keep current file. Allowed file types: PDF, DOC, DOCX, PNG, JPG, JPEG
                                    </small>
                                    @error('coc_copy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mg-t-30">
                                    <button class="btn btn-main-primary pd-x-20" type="submit">
                                        <i class="fas fa-save"></i> Update Certificate
                                    </button>
                                    <a href="{{ route('coc.index') }}" class="btn btn-secondary pd-x-20">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
<!--Internal  Select2 js -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<!--Internal Fancy uploader js-->
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<!--Internal  Form-elements js-->
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<!--Internal Sumoselect js-->
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<!--Internal  Telephone Input js -->
<script src="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js') }}"></script>

<script>
    // Update file input label with selected file name
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });

    // Initialize Select2
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
@endsection
