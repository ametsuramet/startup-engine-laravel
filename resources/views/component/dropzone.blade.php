@push('js')
<script src="/js/dropzone.min.js"></script>
<script type="text/javascript">
    Dropzone.options.dropzone =
     {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
           return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 5000,
        success: responseUpload,
        error: function(file, response)
        {
           return false;
        }
};
</script>
@endpush

@push('css')
<link rel="stylesheet" href="/css/dropzone.min.css">

<style>
    #dropzone {
        display: block;
        min-height: 100px
    }
</style>
@endpush

{!! Form::open(['route' => 'admin.upload', 'method' => "post", "enctype"=>"multipart/form-data","class"=>"dropzone", "id"=>"dropzone"]) !!}

{!! Form::close() !!}