@extends('layouts.dashboard')

@php
// dd($data);
@endphp
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit {!! $data->full_name !!}</h1>
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
                {!! Form::open(['route' => ['user.update', $data->id], 'id' => "form-edit-user"]) !!}
                {!! Form::hidden("_method", "put") !!}
                <div class="form-group row col-md-12">
                    {!! Form::label('first_name', 'Nama Depan', ['class' => 'col-md-3']) !!}
                    {!! Form::text('first_name', $data->first_name, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('middle_name', 'Nama Tengah', ['class' => 'col-md-3']) !!}
                    {!! Form::text('middle_name', $data->middle_name, ['class' => 'form-control col-md-9'])
                    !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('last_name', 'Nama Belakang', ['class' => 'col-md-3']) !!}
                    {!! Form::text('last_name', $data->last_name, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('phone', 'Telp', ['class' => 'col-md-3']) !!}
                    {!! Form::text('phone', $data->phone, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('gender', 'Jenis Kelamin', ['class' => 'col-md-3']) !!}
                    {!! Form::select('gender', ['male' => "Laki-laki", "female" => 'Perempuan'], $data->gender, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('province_id', 'Provinsi', ['class' => 'col-md-3']) !!}
                    {!! Form::select('province_id', $provinces, $data->province_id, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('regency_id', 'Kota/Kabupaten', ['class' => 'col-md-3']) !!}
                    {!! Form::select('regency_id', $regencies, $data->regency_id, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('district_id', 'Kecamatan', ['class' => 'col-md-3']) !!}
                    {!! Form::select('district_id', $districts, $data->district_id, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('village_id', 'Desa/Kelurahan', ['class' => 'col-md-3']) !!}
                    {!! Form::select('village_id', $villages, $data->village_id, ['class' => 'form-control col-md-9']) !!}
                </div>
                <div class="form-group row col-md-12">
                    {!! Form::label('address', 'Alamat', ['class' => 'col-md-3']) !!}
                    {!! Form::textarea('address', $data->address, ['class' => 'form-control col-md-9']) !!}
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
                <img class="img-profile rounded-circle mt-2" style="width: 120px" src="{!! ($data->photo)  ? $data->photo :  '/images/user.png'!!}">
            </div>
        </div>


    </div>
</div>
@endsection
@push('js0')
<script type="text/javascript">
    function save() {
        $('#form-edit-user').submit();
    }
    function responseUpload(file, resp) {
        $('.path').val(resp.data.path);
        $('#form-edit-user').submit();
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