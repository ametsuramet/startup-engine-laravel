@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tugas</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Download</a>
    
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
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Dibuat</th>
                        <th>Ditugaskan kepada</th>
                        <th>Tgl</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Dibuat</th>
                        <th>Ditugaskan kepada</th>
                        <th>Tgl</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data->items() as $i => $item)
                    <tr>
                        <td>{!! $i + 1 !!}</td>
                        <td>{!! $item->name !!}</td>
                        <td>{!! $item->description !!}</td>
                        <td>{!! $item->created->full_name !!}</td>
                        <td>{!! $item->assigned->full_name !!}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection