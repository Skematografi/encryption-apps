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
                        <h4 class="m-0 font-weight-bold text-primary">Storages</h4>
                    </div>
                    <div class="col-6 text-right">
                        @if ($access['is_insert'])
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelUser"
                                onclick="add()">Upload</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0" style="font-size: 15px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Modified</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storages as $item)
                                <tr>
                                    <td class="{{ $item['id'] . 'name' }} text-left">{{ $item['name'] }}</td>
                                    <td class="{{ $item['id'] . 'size' }} text-left">{{ $item['size'] }}</td>
                                    <td class="{{ $item['id'] . 'updated_at' }}">
                                        {{ date('d-m-Y H:i:s', strtotime($item['updated_at'])) }}</td>
                                    <td class="{{ $item['id'] . 'owner' }}">{{ $item['owner'] }}</td>
                                    <td class="{{ $item['id'] . 'status' }}">{{ $item['status'] }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if ($access['is_edit'])
                                                <a href="/storages/{{ $item['id'] }}/edit" class="text-primary mr-3"
                                                    title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if ($access['is_delete'])
                                                {{ Form::open(['route' => ['storages.destroy', $item['id']], 'method' => 'delete']) }}
                                                <a href="javascript:void(0);" onclick="$(this).closest('form').submit();"
                                                    class="text-danger mr-3" title="Delete"><i class="fa fa-trash"></i></a>
                                                {{ Form::close() }}
                                            @endif
                                            @if ($access['is_edit'])
                                                <a href="/storages/{{ $item['id'] }}/edit" class="text-success mr-3"
                                                    title="Download">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @endif

                                            @if ($item['status'] == 'Encrypted')
                                                <a href="/storages/{{ $item['id'] }}/edit" class="text-secondary mr-3"
                                                    title="Decryption">
                                                    <i class="fa fa-unlock-alt"></i>
                                                </a>
                                            @else
                                                <a href="/storages/{{ $item['id'] }}/edit" class="text-secondary mr-3"
                                                    title="Encryption">
                                                    <i class="fa fa-key"></i>
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

    <div class="modal fade" id="modelUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('storages.store') }}" method="POST" id="formUpload" class="dropzone">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btnUpload" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    @push('script')
        <script>

            function add() {
                $('#modalTitle').html('Upload File');
                $('#fileName').val('');
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
