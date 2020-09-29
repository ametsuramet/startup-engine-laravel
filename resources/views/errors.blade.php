@if ($message = session('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
@if ($message = session('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $errors->first() }}</strong>
</div>
@endif
@push('js')
<script>
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
</script>
@endpush