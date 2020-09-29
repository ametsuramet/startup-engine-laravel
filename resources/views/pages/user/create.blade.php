@extends('layouts.dashboard')

@php
// dd($data);
@endphp
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
    <a href="javascript:void(0)" onclick="save()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-save fa-sm text-white-50"></i> Simpan</a>

</div>

<div class="row">
    <div class="col-md-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => ['user.store'], 'id' => "form-edit-store"]) !!}
                <div class="form-group row col-md-12">
                    {!! Form::label('email', 'Email', ['class' => 'col-md-3']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('password', 'Password', ['class' => 'col-md-3']) !!}
                    {!! Form::password('password', ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('confirm_password', 'Ulangi Password', ['class' => 'col-md-3']) !!}
                    {!! Form::password('confirm_password', ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('first_name', 'Nama Depan', ['class' => 'col-md-3']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('middle_name', 'Nama Tengah', ['class' => 'col-md-3']) !!}
                    {!! Form::text('middle_name', old('middle_name'), ['class' => 'form-control col-md-9'])
                    !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('last_name', 'Nama Belakang', ['class' => 'col-md-3']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('phone', 'Telp', ['class' => 'col-md-3']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('gender', 'Jenis Kelamin', ['class' => 'col-md-3']) !!}
                    {!! Form::select('gender', ['male' => "Laki-laki", "female" => 'Perempuan'], old('gender'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('province_id', 'Provinsi', ['class' => 'col-md-3']) !!}
                    {!! Form::select('province_id', $provinces, old('province_id'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('regency_id', 'Kota/Kabupaten', ['class' => 'col-md-3']) !!}
                    {!! Form::select('regency_id', $regencies, old('regency_id'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('district_id', 'Kecamatan', ['class' => 'col-md-3']) !!}
                    {!! Form::select('district_id', $districts, old('district_id'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('village_id', 'Desa/Kelurahan', ['class' => 'col-md-3']) !!}
                    {!! Form::select('village_id', $villages, old('village_id'), ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('address', 'Alamat', ['class' => 'col-md-3']) !!}
                    {!! Form::textarea('address', old('address'), ['class' => 'form-control col-md-9']) !!}
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
            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                @include('component.dropzone')
            </div>
        </div>


    </div>
</div>
@endsection
@push('js0')
<script type="text/javascript">
    function save() {
        $('#form-edit-store').submit();
    }
    function responseUpload(file, resp) {
        $('.path').val(resp.data.path);
        $('#form-edit-store').submit();
    }

    $('#province_id').change(function() {
        var province_id = $(this).val()
        $.get('/api/v1/master/regency?province_id='+province_id, function(resp) {
            $('#regency_id').html( resp.data.map(function(d) {
                return `<option value=${d.id}>${d.name}</option>`;
            }))
            $('#district_id').html(null)
            $('#village_id').html(null)
        })
    })
    $('#regency_id').change(function() {
        var regency_id = $(this).val()
        $.get('/api/v1/master/district?regency_id='+regency_id, function(resp) {
            $('#district_id').html( resp.data.map(function(d) {
                return `<option value=${d.id}>${d.name}</option>`;
            }))
            $('#village_id').html(null)
        })
    })
    $('#district_id').change(function() {
        var district_id = $(this).val()
        $.get('/api/v1/master/village?district_id='+district_id, function(resp) {
            $('#village_id').html( resp.data.map(function(d) {
                return `<option value=${d.id}>${d.name}</option>`;
            }))
        })
    })
    $('#village_id').change(function() {
        var village_id = $(this).val()
    })
    
</script>
@endpush