@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tugas</h1>
    <a href="{!! route('task.create') !!}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah Tugas</a>

</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tgl</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Dibuat</th>
                        <th>Ditugaskan kepada</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Tgl</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Dibuat</th>
                        <th>Ditugaskan kepada</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data->items() as $i => $item)
                    <tr>
                        <td>{!! $i + 1 !!}</td>
                        <td>{!! parseDate($item->start_date, 'd-m-Y') !!}</td>
                        <td>{!! $item->name !!}</td>
                        <td>{!! $item->description !!}</td>
                        <td>{!! $item->created->full_name !!}</td>
                        <td>{!! $item->assigned->full_name !!}</td>

                        <td style="text-align:right">

                            {!! Form::open(['route' => ['task.destroy', $item->id]]) !!}
                            {!! Form::hidden('_method', "delete") !!}
                            <a href="{!! route('task.show', ['task' => $item->id]) !!}"
                                class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            <a href="javascript:void(0)"
                                onclick='showEditModal("{!! route("task.update", ["task" => $item->id]) !!}", "{!! $item->name !!}", "{!! $item->description !!}", "{!! $item->start_date !!}", "{!! $item->created->id !!}", "{!! $item->assigned->id !!}" );'
                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade " id="task-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        {!! Form::open(['url' => "", 'method' => 'post', "id" => "task-edit"]) !!}
        {!! Form::hidden("_method", "put", ) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-md-12">
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
                        <textarea class="form-control col-md-9" name="description" id="" cols="30" rows="10"></textarea>
                    </div>
                    {!! Form::hidden('type', 'task') !!}
                    {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}


                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    Number.prototype.pad = function(size) {
        var s = String(this);
        while (s.length < (size || 2)) {s = "0" + s;}
        return s;
    }
    var data = ''
        function showEditModal(url, name, description, start_date, createdBy, assignedTo) {
            var d = new Date(start_date)
            var start =  d.getFullYear()   + "-" + (d.getMonth()+1) + "-" +d.getDate().pad(2)+ "T" +d.getHours() + ":" + d.getMinutes();
            console.log(start)
            
            var form = $('#task-edit')
            form.attr("action", url)
            form.find('[name=name]').val(name)
            form.find('[name=description]').val(description)
            form.find('[name=created_by]').val(createdBy)
            form.find('[name=assigned_to]').val(assignedTo)
            form.find('[name=start_date]').val(start)
            $('#task-edit-modal').modal('show')
        }
      
</script>
@endpush