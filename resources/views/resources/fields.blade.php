<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter resource title', 'required' => true]) !!}
    <small class="form-text text-muted">Enter a descriptive title for the resource</small>
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('category', [
        '' => 'Select Category',
        'documents' => 'Documents',
        'videos' => 'Videos',
        'images' => 'Images',
        'presentations' => 'Presentations',
        'spreadsheets' => 'Spreadsheets',
        'audio' => 'Audio',
        'other' => 'Other'
    ], null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('type', [
        '' => 'Select Type',
        'pdf' => 'PDF Document',
        'doc' => 'Word Document',
        'docx' => 'Word Document (DOCX)',
        'xls' => 'Excel Spreadsheet',
        'xlsx' => 'Excel Spreadsheet (XLSX)',
        'ppt' => 'PowerPoint Presentation',
        'pptx' => 'PowerPoint Presentation (PPTX)',
        'video' => 'Video',
        'image' => 'Image',
        'audio' => 'Audio',
        'other' => 'Other'
    ], null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- File Upload Field -->
<div class="form-group col-sm-12">
    {!! Form::label('file', 'Upload File:', ['class' => 'font-weight-bold']) !!}
    @if(isset($resource) && $resource->file_url)
        <span class="text-success ml-2">
            <i class="fas fa-check-circle"></i> File already uploaded
        </span>
    @else
        <span class="text-danger">*</span>
    @endif
    
    <div class="custom-file">
        {!! Form::file('file', [
            'class' => 'custom-file-input', 
            'id' => 'fileUpload',
            'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.mp3,.wav'
        ]) !!}
        <label class="custom-file-label" for="fileUpload" id="fileLabel">Choose file</label>
    </div>
    
    <small class="form-text text-muted">
        Accepted formats: PDF, DOC, XLS, PPT, Images (JPG, PNG), Videos (MP4, AVI), Audio (MP3, WAV). Max size: 20MB
    </small>
    
    @if(isset($resource) && $resource->file_url)
        <div class="mt-2 p-2 bg-light border rounded">
            <strong>Current file:</strong>
            <a href="{{ $resource->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary ml-2">
                <i class="fas fa-download"></i> View/Download Current File
            </a>
            @if(isset($resource->size))
                <span class="ml-2 text-muted">Size: {{ $resource->size }}</span>
            @endif
        </div>
    @endif
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:', ['class' => 'font-weight-bold']) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control', 
        'rows' => 4,
        'placeholder' => 'Enter a detailed description of the resource...'
    ]) !!}
    <small class="form-text text-muted">Provide additional details about this resource</small>
</div>

<!-- Author Field -->
<div class="form-group col-sm-6">
    {!! Form::label('author', 'Author:', ['class' => 'font-weight-bold']) !!}
    {!! Form::text('author', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter author name'
    ]) !!}
    <small class="form-text text-muted">Name of the author or creator</small>
</div>

<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Publication Date:', ['class' => 'font-weight-bold']) !!}
    {!! Form::date('date', null, [
        'class' => 'form-control',
        'id' => 'date'
    ]) !!}
    <small class="form-text text-muted">Date when this resource was published</small>
</div>

<!-- Tags Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tags', 'Tags:', ['class' => 'font-weight-bold']) !!}
    {!! Form::text('tags', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter tags separated by commas (e.g., education, training, manual)',
        'data-role' => 'tagsinput'
    ]) !!}
    <small class="form-text text-muted">Add tags to help categorize and search for this resource</small>
</div>

<!-- Featured Field -->
<div class="form-group col-sm-4">
    <div class="custom-control custom-switch mt-4">
        {!! Form::hidden('featured', 0) !!}
        {!! Form::checkbox('featured', '1', null, ['class' => 'custom-control-input', 'id' => 'featuredSwitch']) !!}
        <label class="custom-control-label font-weight-bold" for="featuredSwitch">
            <i class="fas fa-star text-warning"></i> Featured Resource
        </label>
    </div>
    <small class="form-text text-muted">Mark as featured to highlight on homepage</small>
</div>

<!-- Preview Field -->
<div class="form-group col-sm-4">
    <div class="custom-control custom-switch mt-4">
        {!! Form::hidden('preview', 0) !!}
        {!! Form::checkbox('preview', '1', null, ['class' => 'custom-control-input', 'id' => 'previewSwitch']) !!}
        <label class="custom-control-label font-weight-bold" for="previewSwitch">
            <i class="fas fa-eye text-info"></i> Enable Preview
        </label>
    </div>
    <small class="form-text text-muted">Allow users to preview this resource</small>
</div>

<!-- Rating Field -->
<div class="form-group col-sm-4">
    {!! Form::label('rating', 'Rating:', ['class' => 'font-weight-bold']) !!}
    {!! Form::select('rating', [
        '' => 'No Rating',
        '1' => '⭐ 1 Star',
        '2' => '⭐⭐ 2 Stars',
        '3' => '⭐⭐⭐ 3 Stars',
        '4' => '⭐⭐⭐⭐ 4 Stars',
        '5' => '⭐⭐⭐⭐⭐ 5 Stars'
    ], null, ['class' => 'form-control']) !!}
    <small class="form-text text-muted">Optional rating (1-5 stars)</small>
</div>

<!-- Size Field (Auto-calculated, read-only) -->
<div class="form-group col-sm-6">
    {!! Form::label('size', 'File Size:', ['class' => 'font-weight-bold']) !!}
    {!! Form::text('size', null, [
        'class' => 'form-control',
        'readonly' => true,
        'placeholder' => 'Auto-calculated on upload'
    ]) !!}
    <small class="form-text text-muted">File size (auto-calculated)</small>
</div>

<!-- Downloads Field (Auto-tracked, read-only) -->
<div class="form-group col-sm-6">
    {!! Form::label('downloads', 'Downloads:', ['class' => 'font-weight-bold']) !!}
    {!! Form::number('downloads', isset($resource) ? $resource->downloads : 0, [
        'class' => 'form-control',
        'min' => '0',
        'readonly' => true,
        'placeholder' => '0'
    ]) !!}
    <small class="form-text text-muted">Download count (auto-tracked)</small>
</div>

@push('page_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-tagsinput@0.8.0/dist/bootstrap-tagsinput.css">
<style>
    .custom-file-label::after {
        content: "Browse";
    }
    
    .bootstrap-tagsinput {
        width: 100%;
        min-height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    
    .bootstrap-tagsinput .tag {
        background-color: #007bff;
        color: white;
        padding: 3px 8px;
        border-radius: 3px;
        margin-right: 5px;
        margin-bottom: 3px;
    }
    
    .form-group label.font-weight-bold {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    
    .custom-switch .custom-control-label::before {
        height: 1.5rem;
        width: 2.75rem;
    }
    
    .custom-switch .custom-control-label::after {
        height: calc(1.5rem - 4px);
        width: calc(1.5rem - 4px);
    }

    .text-danger {
        font-weight: bold;
    }
</style>
@endpush

@push('page_scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-tagsinput@0.8.0/dist/bootstrap-tagsinput.min.js"></script>
<script>
$(document).ready(function() {
    // Update file input label with selected filename
    $('#fileUpload').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $('#fileLabel').html(fileName || 'Choose file');
        
        // Validate file size (20MB max)
        if (this.files[0]) {
            var fileSize = this.files[0].size / 1024 / 1024; // in MB
            if (fileSize > 20) {
                alert('File size exceeds 20MB. Please choose a smaller file.');
                $(this).val('');
                $('#fileLabel').html('Choose file');
                return;
            }
            
            // Display file size
            var fileSizeText = fileSize < 1 
                ? (fileSize * 1024).toFixed(2) + ' KB' 
                : fileSize.toFixed(2) + ' MB';
            $('input[name="size"]').val(fileSizeText);
        }
    });
    
    // Initialize tags input
    $('input[data-role="tagsinput"]').tagsinput({
        trimValue: true,
        confirmKeys: [13, 44], // Enter and comma
        tagClass: 'badge badge-primary'
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        var isEdit = {{ isset($resource) ? 'true' : 'false' }};
        var hasFile = $('#fileUpload').val() !== '';
        var hasExistingFile = {{ isset($resource) && $resource->file_url ? 'true' : 'false' }};
        
        // Check if file is required (only for new resources)
        if (!isEdit && !hasFile) {
            e.preventDefault();
            alert('Please select a file to upload.');
            $('#fileUpload').focus();
            return false;
        }
        
        // Show loading indicator
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        return true;
    });
});
</script>
@endpush