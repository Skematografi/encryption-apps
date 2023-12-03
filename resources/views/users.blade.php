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
                        <h6 class="m-0 font-weight-bold text-primary">Master User</h6>
                    </div>
                    <div class="col-6 text-right">
                        @hasrole('superadmin')
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSupplier"
                                onclick="add()">Tambah</button>
                        @endhasrole
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0"
                        style="font-size: 15px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>USERNAME</th>
                                <th>NAMA LENGKAP</th>
                                <th>EMAIL</th>
                                <th>TELEPON</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td class="{{ $item['id'] . 'username' }}">{{ $item['username'] }}</td>
                                    <td class="{{ $item['id'] . 'name' }}">{{ $item['name'] }}</td>
                                    <td class="{{ $item['id'] . 'phone' }}">{{ $item['phone'] }}</td>
                                    <td class="{{ $item['id'] . 'email' }}">{{ $item['email'] }}</td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}"
                                            class="text-info" title="Klik untuk edit user"><i
                                                class="fa fa-edit"></i></a><br>
                                        {{ Form::open(['route' => ['supplier.destroy', $item['id']], 'method' => 'delete']) }}
                                        <a href="javascript:void(0);" onclick="$(this).closest('form').submit();"
                                            class="text-danger" title="Klik untuk hapus user"><i
                                                class="fa fa-trash"></i></a>
                                        {{ Form::close() }}
                                        <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}"
                                            class="text-info" title="Klik untuk reset password user"><i
                                                class="fa fa-redo"></i></a><br>
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
    <div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('supplier.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control field-supplier" id="name" name="name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control field-supplier" id="name" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="code">Telepon <span class="text-danger">*</span></label>
                                <input type="number" class="form-control field-supplier" id="phone" name="phone"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control field-supplier" id="email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Role <span class="text-danger">*</span></label>
                            <input type="email" class="form-control field-supplier" id="email" name="email" required>
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
                $('.field-supplier').val('');
                $('#code').attr('readonly', false);
            }

            function edit(ele) {
                let id = $(ele).attr('data-id');
                let name = $('.' + id + 'name').html();
                let phone = $('.' + id + 'phone').html();
                let email = $('.' + id + 'email').html();

                $('#modalTitle').html('Edit User');
                $('#code').attr('readonly', true);

                $('#supplier_id').val(id);
                $('#name').val(name);
                $('#phone').val(phone);
                $('#email').val(email);

                $('#modalSupplier').modal('show');


            }
        </script>
    @endpush
@endsection
