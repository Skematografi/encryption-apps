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
                        <h6 class="m-0 font-weight-bold text-primary">Master Produk</h6>
                    </div>
                    <div class="col-6 text-right">
                        @hasrole('ppic')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProduk" onclick="addProduct()">Tambah Produk</button>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBarang" onclick="add()">Tambah Barang</button>
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
                                <th>KODE PRODUK</th>
                                <th>NAMA PRODUK</th>
                                <th>KODE BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>SATUAN</th>
                                <th>KETERANGAN</th>
                                @hasrole('ppic')
                                <th>AKSI</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($products as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="{{ $item['id'].'code' }}">{{ $item['code'] }}</td>
                                    <td class="{{ $item['id'].'name' }}">{{ $item['name'] }}</td>
                                    <td class="{{ $item['id'].'code_item' }}">{{ $item['code_item'] }}</td>
                                    <td class="{{ $item['id'].'item' }}">{{ $item['item'] }}</td>
                                    <td class="{{ $item['id'].'unit' }}">{{ $item['unit'] }}</td>
                                    <td class="{{ $item['id'].'description' }}">{{ $item['description'] }}</td>
                                    @hasrole('ppic')
                                    <td>
                                        <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}" class="text-info" title="Klik untuk edit produk"><i class="fa fa-edit"></i></a><br>
                                        {{ Form::open(['route' => ['product.destroy', $item['id']], 'method' => 'delete']) }}
                                            <a href="javascript:void(0);" onclick="$(this).closest('form').submit();" class="text-danger" title="Klik untuk hapus produk"><i class="fa fa-trash"></i></a>
                                        
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


    <!-- Modal Barang-->
    <div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('product.store')}}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Produk <span class="text-danger">*</span></label>
                        <div class="form-kode">
                            <select class="form-control field-product" id="products_id" name="products_id" onchange="getProductName()" required>
                                <option value="" selected disabled>-- Pilih Kode Produk --</option>
                            </select>
                        </div>
                        <input type="hidden" class="form-control field-product" id="detail_id" name="detail_id">
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="name_product" name="name_product" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="code_item" name="code_item" required>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="item" name="item" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Satuan <span class="text-danger">*</span></label>
                        <div class="form-unit">
                            <select class="form-control field-product" id="unit" name="unit" required>
                                <option value="" selected disabled>-- Pilih Satuan --</option>
                                <option value="LBR">LBR</option>
                                <option value="PCS">PCS</option>
                                <option value="RLL">RLL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control field-product" id="description" name="description" rows="3"></textarea>
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

    <!-- Modal Produk-->
    <div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Tambah Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="detail_product/store" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="code" name="code" required>
                        <input type="hidden" class="form-control field-product" id="product_id" name="product_id">
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="name" name="name" required>
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
        function add(){
            $('#modalTitle').html('Tambah Barang');
            $('.field-product').val('');
            $('.form-unit select').val('');
            $('#code_item').attr('readonly', false);

            ajaxGetProduct();
        }

        function ajaxGetProduct(){
            $.ajax({
                type : 'GET',
                url : '{{ url("data/product") }}',
                dataType: 'json',
                success : function(res){
                    $('#products_id').empty().append('<option value="" selected disabled>-- Pilih Kode Produk --</option>');
                    res.forEach(function(data){
                        $('#products_id').append('<option value="'+data.id+'" data-nama="'+data.name+'">'+data.code+'</option>');
                    });
                },
                error : function(err){
                   console.log(err)
                }
            });
        }

        function addProduct(){
            $('#code, #name').val('');
        }

        function edit(ele){

            ajaxGetProduct(); 
            let id = $(ele).attr('data-id');
            let code = $('.'+id+'products_id').html();
            let name = $('.'+id+'name').html();
            let code_item = $('.'+id+'code_item').html();
            let item = $('.'+id+'item').html();
            let unit = $('.'+id+'unit').html();
            let description = $('.'+id+'description').html();

            $('#modalTitle').html('Edit Barang');
            $('#code_item').attr('readonly', true);

            $('#detail_id').val(id);
            $('#name_product').val(name);
            $('#code_item').val(code_item);
            $('#item').val(item);
            $('.form-unit select').val(unit);
            $('#description').val(description);

            $('#modalBarang').modal('show');


        }

        function getProductName(){
            let name =$('#products_id').find(":selected").attr('data-nama');
            $('#name_product').val(name);
        }
    </script>

    @endpush

@endsection
