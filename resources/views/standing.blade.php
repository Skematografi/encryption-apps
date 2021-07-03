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
                        <h6 class="m-0 font-weight-bold text-primary">Out Standing PO</h6>
                    </div>
                    <div class="col-6 text-right">
                        @hasrole('ppic')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalStanding" onclick="add()">Tambah</button>
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
                                <th>TANGGAL PO</th>
                                <th>NOMOR PO</th>
                                <th>KODE BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>KODE SUPPLIER</th>
                                <th>NAMA SUPLLIER</th>
                                <th>STOK</th>
                                @hasrole('ppic')
                                <th>AKSI</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($standings as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="{{ $item['id'].'date_po' }}">{{ date('d-m-Y', strtotime($item['date_po'])) }}</td>
                                    <td class="{{ $item['id'].'no_po' }}">{{ $item['no_po'] }}</td>
                                    <td class="{{ $item['id'].'products_id' }}">{{ $item['products_id'] }}</td>
                                    <td class="{{ $item['id'].'products_name' }}">{{ $item['products_name'] }}</td>
                                    <td class="{{ $item['id'].'suppliers_id' }}">{{ $item['suppliers_id'] }}</td>
                                    <td class="{{ $item['id'].'suppliers_name' }}">{{ $item['suppliers_name'] }}</td>
                                    <td class="{{ $item['id'].'stock' }}">{{ $item['stock'] }}</td>
                                    @hasrole('ppic')
                                    <td>
                                        {{-- <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}" class="text-info" title="Klik untuk edit out standing po"><i class="fa fa-edit"></i></a><br> --}}
                                        {{ Form::open(['route' => ['out_standing_po.destroy', $item['id']], 'method' => 'delete']) }}
                                            <a href="javascript:void(0);" onclick="$(this).closest('form').submit();" class="text-danger" title="Klik untuk hapus return pm r1"><i class="fa fa-trash"></i></a>
                                        
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
    <div class="modal fade" id="modalStanding" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('out_standing_po.store')}}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Tanggal PO <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product datepicker" id="date_po" name="date_po" placeholder="dd-mm-yyyy" required>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nomor PO <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="no_po" name="no_po" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Produk <span class="text-danger">*</span></label>
                        <div class="form-kode">
                            <select class="form-control field-product" id="products_id" name="products_id" onchange="getProductName()" required>
                                <option value="" selected disabled>-- Pilih Kode Produk --</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="name_product" name="name_product" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Barang <span class="text-danger">*</span></label>
                        <div class="form-kode">
                            <select class="form-control field-product" id="detail_id" name="detail_id" onchange="getItemName()" required>
                                <option value="" selected disabled>-- Pilih Kode Barang --</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="item" name="item" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="code">Kode Supplier <span class="text-danger">*</span></label>
                        <div class="form-kode">
                            <select class="form-control field-product" id="suppliers_id" name="suppliers_id" onchange="getSupplierName()" required>
                                <option value="" selected disabled>-- Pilih Kode Supplier --</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label for="name">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="name_supplier" name="name_supplier" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                        <label for="name">Stok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-product" id="stock" name="stock">
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
            $('#modalTitle').html('Tambah Out Standing PO');
            $('.field-product').val('');
            $('.form-unit select').val('');
            $('#code_item').attr('readonly', false);

            ajaxGetProduct();

            ajaxGetSupplier();
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

        function ajaxGetSupplier(){
            $.ajax({
                type : 'GET',
                url : '{{ url("data/supplier") }}',
                dataType: 'json',
                success : function(res){
                    $('#suppliers_id').empty().append('<option value="" selected disabled>-- Pilih Kode Supplier --</option>');
                    res.forEach(function(data){
                        $('#suppliers_id').append('<option value="'+data.id+'" data-nama="'+data.name+'">'+data.code+'</option>');
                    });
                },
                error : function(err){
                   console.log(err)
                }
            });
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

            $('#modalTitle').html('Edit Out Standing PO');
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

            $.ajax({
                type : 'POST',
                url : '{{ url("data/items") }}',
                data : {
                    "_token": "{{ csrf_token() }}",
                    "products_id" : $('#products_id').val()
                },
                success : function(res){
                    $('#item').val('');
                    $('#detail_id').empty().append('<option value="" selected disabled>-- Pilih Kode Barang --</option>');
                    res.forEach(function(data){
                        $('#detail_id').append('<option value="'+data.id+'" data-nama="'+data.item+'">'+data.code_item+'</option>');
                    });
                },
                error : function(err){
                   console.log(err)
                }
            });
        }

        function getItemName(){
            let name =$('#detail_id').find(":selected").attr('data-nama');
            $('#item').val(name);
        }

        function getSupplierName(){
            let name =$('#suppliers_id').find(":selected").attr('data-nama');
            $('#name_supplier').val(name);
        }

        
    </script>

    @endpush

@endsection
