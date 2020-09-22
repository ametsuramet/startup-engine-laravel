@extends('layouts.dashboard')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Tugas</h6>
    </div>
    <div class="card-body">
        {!! Form::open(['route' => 'task.store', 'method' => 'post']) !!}
        <div class="form-group row">
            {!! Form::label('created_by', 'Pemberi Tugas', ['class' => 'col-md-3']) !!}
            {!! Form::select('created_by', $users, null, ['class' => 'form-control col-md-9']) !!}
        </div>
        <div class="form-group row">
            {!! Form::label('assigned_to', 'Kepada', ['class' => 'col-md-3']) !!}
            {!! Form::select('assigned_to', $users, null, ['class' => 'form-control col-md-9']) !!}
        </div>
        <div class="form-group row">
            {!! Form::label('start_date', 'Mulai', ['class' => 'col-md-3']) !!}
            {!! Form::datetimeLocal('start_date', null, ['class' => 'form-control col-md-9']) !!}
        </div>
        <div class="form-group row">
            {!! Form::label('name', 'Judul', ['class' => 'col-md-3']) !!}
            {!! Form::text('name', null, ['class' => 'form-control col-md-9']) !!}
        </div>
        <div class="form-group row">
            {!! Form::label('description', 'Keterangan', ['class' => 'col-md-3']) !!}
            <textarea  class="form-control col-md-9" name="description" id="" cols="30" rows="10"></textarea>
        </div>
        {!! Form::hidden('type', 'task') !!}
        {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection