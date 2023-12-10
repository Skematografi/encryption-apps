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
                        <h4 class="m-0 font-weight-bold text-primary">Users</h4>
                    </div>
                    <div class="col-6 text-right">
                        @if ($access['is_insert'])
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelUser"
                                onclick="add()">Tambah</button>
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
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Telepon</th>
                                <th>E-mail</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td class="{{ $item['id'] . 'username' }}">{{ $item['username'] }}</td>
                                    <td class="{{ $item['id'] . 'name' }}">{{ $item['name'] }}</td>
                                    <td class="{{ $item['id'] . 'phone' }}">{{ $item['phone'] }}</td>
                                    <td class="{{ $item['id'] . 'email' }}">{{ $item['email'] }}</td>
                                    <td class="{{ $item['id'] . 'role-name' }}">{{ $item->role->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <input type="hidden" class="form-control {{ $item['id'] . 'role-id' }}" name="{{ $item['id'] . 'role-id' }}"
                                                    value="{{ $item->role->id }}">
                                            @if ($access['is_edit'])
                                                <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}"
                                                    class="text-primary mr-3" title="Klik untuk edit user"><i
                                                        class="fa fa-edit"></i></a>
                                            @endif
                                            @if ($access['is_delete'] && auth()->user()->id != $item['id'])
                                                {{ Form::open(['route' => ['users.destroy', $item['id']], 'method' => 'delete']) }}
                                                <a href="javascript:void(0);" onclick="$(this).closest('form').submit();"
                                                    class="text-danger mr-3" title="Klik untuk hapus user"><i
                                                        class="fa fa-trash"></i></a>
                                                {{ Form::close() }}
                                            @endif
                                            @if ($access['is_edit'] && auth()->user()->id != $item['id'])
                                                <a href="/users/{{ $item['id'] }}/reset" class="text-success" title="Klik untuk reset password user">
                                                    <i class="fa fa-redo"></i>
                                                </a>
                                            @endif
                                        </div>
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


    <!-- Modal -->
    <div class="modal fade" id="modelUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control field-user" maxlength="10" id="username" name="username"
                                    required>
                                <input type="hidden" class="form-control field-user" id="user_id" name="user_id">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control field-user" maxlength="50" id="name" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="phone">Telepon <span class="text-danger">*</span></label>
                                <input type="number" class="form-control field-user" onKeyPress="if(this.value.length==14) return false;" id="phone" name="phone"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control field-user" maxlength="50" id="email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control field-user" minlength="8" maxlength="20" id="password" name="password"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role_id">Role <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-control field-user" id="role_id" required>
                                    <option value="">- Pilih Role -</option>
                                    @foreach ($roles as $row)
                                        <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function add() {
                $('#modalTitle').html('Tambah User');
                $('#username').attr('readonly', false);
                $('#password').attr('required', true);
                $('.field-user').val('');
            }

            function edit(ele) {
                let id = $(ele).attr('data-id');
                let username = $('.' + id + 'username').html();
                let name = $('.' + id + 'name').html();
                let phone = $('.' + id + 'phone').html();
                let email = $('.' + id + 'email').html();
                let roleId = $('.' + id + 'role-id').val();

                $('#modalTitle').html('Edit User');

                $('#user_id').val(id);
                $('#username').val(username).attr('readonly', true);
                $('#password').removeAttr('required');
                $('#name').val(name);
                $('#phone').val(phone);
                $('#email').val(email);
                $('#role_id').val(roleId);

                $('#modelUser').modal('show');


            }
        </script>
    @endpush
@endsection
