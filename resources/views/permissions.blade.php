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
                        <h4 class="m-0 font-weight-bold text-primary">Tambah Role</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="name">Nama Role <span class="text-danger">*</span></label>
                            <input type="hidden" class="form-control" id="role_id" name="role_id"
                                value="{{ isset($roles['id']) ? $roles['id'] : 0 }}">
                            <input type="text" class="form-control" maxlength="15" id="name" name="name"
                                value="{{ isset($roles['name']) ? $roles['name'] : '' }}" required>
                        </div>
                    </div>

                    <hr>
                    <h6 class="m-0 font-weight-bold text-secondary">Hak Akses</h6>
                    <hr>
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0" style="font-size: 15px;">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:50%">MODULE</th>
                                <th style="width:10%">VIEW</th>
                                <th style="width:10%">INSERT</th>
                                <th style="width:10%">EDIT</th>
                                <th style="width:10%">DELETE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modules as $key => $item)
                                <tr>
                                    <td>
                                        {{ $item['model'] }}
                                    </td>
                                    <td>
                                        <div class="form-check mb-3">
                                            <input type="hidden" class="form-control" name="modules[{{ $item['permission_id'] }}][access_control_id]"
                                                value="{{ $item['access_control_id'] }}">
                                            <input type="hidden" class="form-control" name="modules[{{ $item['permission_id'] }}][permission_id]"
                                                value="{{ $item['permission_id'] }}">
                                            <input class="form-check-input" type="checkbox"
                                                name="modules[{{ $item['permission_id'] }}][is_view]"
                                                value="{{ $item['is_view'] }}"
                                                {{ $item['is_view'] ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="modules[{{ $item['permission_id'] }}][is_insert]"
                                                value="{{ $item['is_insert'] }}"
                                                {{ $item['is_insert'] ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="modules[{{ $item['permission_id'] }}][is_edit]"
                                                value="{{ $item['is_edit'] }}"
                                                {{ $item['is_edit'] ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="modules[{{ $item['permission_id'] }}][is_delete]"
                                                value="{{ $item['is_delete'] }}"
                                                {{ $item['is_delete'] ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-right">
                        <a href="/roles" class="btn btn-secondary mr-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
