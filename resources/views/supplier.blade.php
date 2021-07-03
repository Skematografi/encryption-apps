@extends('layouts.app')

@section('content')
<style>
    .table td, .table th {
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
                        <h6 class="m-0 font-weight-bold text-primary">Master Supplier</h6>
                    </div>
                    <div class="col-6 text-right">
                        @hasrole('ppic')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSupplier" onclick="add()">Tambah</button>
                        @endhasrole
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="font-size: 15px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>NO.</th>
                                <th>KODE SUPPLIER</th>
                                <th>NAMA SUPPLIER</th>
                                <th>TELEPON</th>
                                <th>EMAIL</th>
                                <th>ALAMAT</th>
                                @hasrole('ppic')
                                <th>AKSI</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($suppliers as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="{{ $item['id'].'code' }}">{{ $item['code'] }}</td>
                                <td class="{{ $item['id'].'name' }}">{{ $item['name'] }}</td>
                                <td class="{{ $item['id'].'phone' }}">{{ $item['phone'] }}</td>
                                <td class="{{ $item['id'].'email' }}">{{ $item['email'] }}</td>
                                <td class="{{ $item['id'].'address' }}">{{ $item['address'] }}</td>
                                @hasrole('ppic')
                                <td>
                                    <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}" class="text-info" title="Klik untuk edit supplier"><i class="fa fa-edit"></i></a><br>
                                    {{ Form::open(['route' => ['supplier.destroy', $item['id']], 'method' => 'delete']) }}
                                        <a href="javascript:void(0);" onclick="$(this).closest('form').submit();" class="text-danger" title="Klik untuk hapus supplier"><i class="fa fa-trash"></i></a>
                                    {{ Form::close() }}
                                </td>
                                @endhasrole
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
    <div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('supplier.store')}}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Supplier <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-supplier" id="code" name="code" required>
                        <input type="hidden" class="form-control field-supplier" id="supplier_id" name="supplier_id">
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-supplier" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Telepon <span class="text-danger">*</span></label>
                        <input type="number" class="form-control field-supplier" id="phone" name="phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control field-supplier" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control field-supplier" id="address" name="address" rows="3"></textarea>
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
        function add(){
            $('#modalTitle').html('Tambah Supplier');
            $('.field-supplier').val('');
            $('#code').attr('readonly', false);
        }

        function edit(ele){
            let id = $(ele).attr('data-id');
            let code = $('.'+id+'code').html();
            let name = $('.'+id+'name').html();
            let phone = $('.'+id+'phone').html();
            let email = $('.'+id+'email').html();
            let address = $('.'+id+'address').html();

            $('#modalTitle').html('Edit Supplier');
            $('#code').attr('readonly', true);

            $('#supplier_id').val(id);
            $('#code').val(code);
            $('#name').val(name);
            $('#phone').val(phone);
            $('#email').val(email);
            $('#address').val(address);

            $('#modalSupplier').modal('show');


        }
    </script>

    @endpush

@endsection
