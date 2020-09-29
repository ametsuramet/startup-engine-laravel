@extends('layouts.dashboard')

@php
// dd(session('user'));
@endphp
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    <a href="javascript:void(0)" onclick="save()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-save fa-sm text-white-50"></i> Simpan</a>

</div>

<div class="row">
    <div class="col-md-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'admin.updateProfile', 'id' => "form-profile"]) !!}
                <div class="form-group row col-md-12">
                    {!! Form::label('first_name', 'Nama Depan', ['class' => 'col-md-3']) !!}
                    {!! Form::text('first_name', session('user')->first_name, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('middle_name', 'Nama Tengah', ['class' => 'col-md-3']) !!}
                    {!! Form::text('middle_name', session('user')->middle_name, ['class' => 'form-control col-md-9'])
                    !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('last_name', 'Nama Belakang', ['class' => 'col-md-3']) !!}
                    {!! Form::text('last_name', session('user')->last_name, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('phone', 'Telp', ['class' => 'col-md-3']) !!}
                    {!! Form::text('phone', session('user')->phone, ['class' => 'form-control col-md-9']) !!}
                </div>
                {!! Form::hidden("path", null, ['class' => 'path']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">UPLOAD IMAGE</h6>
            </div>
            <div class="card-body">
                @include('component.dropzone')
            </div>
        </div>


    </div>
</div>
@endsection
@push('js0')
<script type="text/javascript">
    function save() {
        $('#form-profile').submit();
    }
    function responseUpload(file, resp) {
        $('.path').val(resp.data.path);
        $('#form-profile').submit();
    }
</script>
@endpush