@extends('layouts.dashboard')


@section('content')
 <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User</h1>
    <a href="{!! route('user.create') !!}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah User</a>

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
                        <th width="60">Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th width="60">Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data->items() as $i => $item)
                    <tr>
                        <td>{!! $i + 1 !!}</td>
                        <td><img class="img-profile rounded-circle" style="width: 60px" src="{!! ($item->photo)  ? $item->photo :  '/images/user.png'!!}"></td>
                        <td>{!! $item->full_name !!}</td>
                        <td>{!! $item->email !!}</td>
                        <td>{!! $item->phone !!}</td>
                        <td style="text-align:right">
                            {!! Form::open(['route' => ['user.destroy', $item->id]]) !!}
                            {!! Form::hidden('_method', "delete") !!}
                            <a href="{!! route('user.edit', ['user' => $item->id]) !!}"
                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            {{-- <a href="javascript:void(0)"
                                onclick='showEditModal("{!! route("user.update", ["user" => $item->id]) !!}", "{!! $item->name !!}", "{!! $item->description !!}", "{!! $item->start_date !!}", "{!! $item->created->id !!}", "{!! $item->assigned->id !!}" );'
                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> --}}
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

@endsection

