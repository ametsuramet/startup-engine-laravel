@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Detail Tugas</h1>
  <a href="#" data-toggle="modal" data-target="#addItems"
    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i>
    Tambah Detail</a>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{!! $data->name !!}</h6>
      </div>
      <div class="card-body">
        {!! $data->description !!}
      </div>
    </div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Tugas</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data->items as $i => $item)
            <tr>
              <td>{!! $i + 1 !!}</td>
              <td>{!! $item->name !!}</td>
              <td>{!! $item->description !!}</td>

            </tr>

            @endforeach
          </tbody>
        </table>
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

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Foto</h6>
      </div>
      <div class="card-body">
        @foreach ($data->images as $image)
        <div class="preview" onclick="previewImage('{!! $image->url !!}')"
          style="background: url({!! $image->url !!}) no-repeat center center; background-size: cover">

        </div>

        @endforeach
      </div>
    </div>

  </div>
</div>

<div class="modal fade " id="addItems" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    {!! Form::open(['url' => route('task-item.store', ['task_id' => $data->id]), 'method' => 'post']) !!}
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Detail</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">


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

      {!! Form::close() !!}
    </div>
  </div>
</div>
<div class="modal fade " id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="width: 100%">

      </div>

    </div>
  </div>
</div>

@endsection
@push('css')
<style>
  .preview {
    width: 100px;
    height: 100px;
    cursor: pointer;
    float: left;
    margin: 5px;
    border-radius: 5px;
    border: 2px solid #dedede;
  }
</style>
@endpush
@push('js0')
<script>
  var taskId = "{!! $data->id !!}"
      function responseUpload(file, resp) {
        // console.log(file)

        $.post("/admin/task/"+taskId+"/addImage", {
          "_token":"{!! csrf_token() !!}",
          "path": resp.data.path
        },function(data, status){
          if (status == "success") location.reload()
          // alert("Data: " + data + "\nStatus: " + status);
        })
      }

      function previewImage(url)
      {
        $('#imagepreview').attr('src', url); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show');
      }
</script>
@endpush