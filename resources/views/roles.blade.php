@extends('layouts.app')

@section('content')
    <style>
        .table td,
        .table th {
            padding: .35rem;
            vertical-align: middle !important;
            text-align: center;
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <h4 class="m-0 font-weight-bold text-primary">Roles</h4>
                    </div>
                    <div class="col-6 text-right">
                        @if ($access['is_insert'])
                            <a href="/roles/create" class="btn btn-primary" title="Klik untuk edit user">
                                Tambah
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0"
                        style="font-size: 15px;">
                        <thead class="thead-dark">
                            <tr>
                                <th width="45%">Role</th>
                                <th width="25%">Modified</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $item)
                                <tr>
                                    <td class="{{ $item['id'] . 'name' }}">{{ $item['name'] }}</td>
                                    <td class="{{ $item['id'] . 'updated_at' }}">{{ date('d-m-Y H:i:s', strtotime($item['updated_at'])) }}</td>
                                    <td>
                                        @if ($item['id'] != 1)
                                            <div class="d-flex justify-content-center">
                                                @if ($access['is_edit'])
                                                    <a href="/roles/{{ $item['id'] }}/edit" class="text-primary mr-3" title="Klik untuk edit user">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($access['is_delete'])
                                                    {{ Form::open(['route' => ['roles.destroy', $item['id']], 'method' => 'delete']) }}
                                                    <a href="javascript:void(0);" onclick="$(this).closest('form').submit();"
                                                        class="text-danger" title="Klik untuk hapus user"><i
                                                            class="fa fa-trash"></i></a>
                                                    {{ Form::close() }}
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
