@extends('layouts.app')

@section('content')
<style>
    .table td, .table th {
        padding: .20rem;
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
                        <h6 class="m-0 font-weight-bold text-primary">Return PM R1</h6>
                    </div>
                    <div class="col-6 text-right">
                        @hasrole('admin_qc')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalReturn" onclick="add()">Tambah</button>
                        @endhasrole
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive table-hover" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;">
                        <thead class="thead-dark">
                            <tr>
                                <th rowspan="2">NO.</th>
                                <th rowspan="2">TANGGAL<br>RETURN</th>
                                <th rowspan="2">KODE<br>BARANG</th>
                                <th rowspan="2">NAMA<br>PM</th>
                                <th rowspan="2">SUPPLIER</th>
                                <th rowspan="2">NO.PO</th>
                                <th rowspan="1" colspan="2">PENERIMAAN</th>
                                <th rowspan="1" colspan="2">PENOLAKAN</th>
                                <th rowspan="1" colspan="2">JUMLAH SAMPLING</th>
                                <th rowspan="2">AQL</th>
                                <th rowspan="2">AC/RC</th>
                                <th rowspan="2">KETERANGAN</th>
                                @hasrole('admin_qc')
                                <th rowspan="2">AKSI</th>
                                @endhasrole
                            </tr>
                            <tr>
                                <th rowspan="1">QTY</th>
                                <th rowspan="1">SATUAN</th>
                                <th rowspan="1">QTY</th>
                                <th rowspan="1">SATUAN</th>
                                <th rowspan="1">QTY</th>
                                <th rowspan="1">SATUAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($returns as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="{{ $item['id'].'date_return' }}">{{ date('d-m-Y', strtotime($item['date_return'])) }}</td>
                                    <td class="{{ $item['id'].'code_item' }}">{{ $item['code_item'] }}</td>
                                    <td class="{{ $item['id'].'item' }}">{{ $item['item'] }}</td>
                                    <td class="{{ $item['id'].'supplier' }}">{{ $item['supplier'] }}</td>
                                    <td class="{{ $item['id'].'no_po' }}">{{ $item['no_po'] }}</td>
                                    <td class="{{ $item['id'].'reception_qty' }}">{{ $item['reception_qty'] }}</td>
                                    <td class="{{ $item['id'].'reception_unit' }}">{{ $item['reception_unit'] }}</td>
                                    <td class="{{ $item['id'].'rejection_qty' }}">{{ $item['rejection_qty'] }}</td>
                                    <td class="{{ $item['id'].'rejection_unit' }}">{{ $item['rejection_unit'] }}</td>
                                    <td class="{{ $item['id'].'example_qty' }}">{{ $item['example_qty'] }}</td>
                                    <td class="{{ $item['id'].'example_unit' }}">{{ $item['example_unit'] }}</td>
                                    <td class="{{ $item['id'].'aql' }}">{{ $item['aql'] }}</td>
                                    <td class="{{ $item['id'].'ac_rc' }}">{{ $item['ac_rc'] }}</td>
                                    <td class="{{ $item['id'].'description' }}">{{ $item['description'] }}</td>
                                    @hasrole('admin_qc')
                                    <td>
                                        {{-- <a href="javascript:void(0);" onclick="edit(this)" data-id="{{ $item['id'] }}" class="text-info" title="Klik untuk edit out standing po"><i class="fa fa-edit"></i></a><br> --}}
                                        {{ Form::open(['route' => ['return_pmr.destroy', $item['id']], 'method' => 'delete']) }}
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


    <!-- Modal -->
    <div class="modal fade" id="modalReturn" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('return_pmr.store')}}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Tanggal Return <small class="text-danger">*</small></label>
                            <input type="text" class="form-control datepicker" id="date_return" name="date_return" placeholder="dd-mm-yyyy" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Nomor PO <small class="text-danger">*</small></label>
                            <select class="form-control" id="out_standing_po_id" name="out_standing_po_id" onchange="getProduct()" required>
                                <option value="" selected disabled>-- Pilih Nomor PO --</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code">Kode Barang <small class="text-danger">*</small></label>
                            <select class="form-control" id="detail_products_id" name="detail_products_id" onchange="getProdSupName()" required>
                                <option value="" selected disabled>-- Pilih Kode Barang --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Nama PM</label>
                            <input type="text" class="form-control" id="detail_products_name" name="detail_products_name" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code">Supplier</label>
                            <input type="text" class="form-control" id="suppliers_name" name="suppliers_name" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Penerimaan Qty</label>
                            <input type="number" class="form-control" id="reception_qty" name="reception_qty" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code">Penerimaan Satuan</label>
                            <input type="text" class="form-control" id="reception_unit" name="reception_unit" readonly>
                            {{-- <select class="form-control" id="reception_unit" name="reception_unit" >
                                <option value="" selected disabled>-- Pilih Satuan --</option>
                                <option value="Lbr">Lbr</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Roll">Roll</option>
                            </select> --}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Penolakan Qty</label>
                            <input type="number" class="form-control" id="rejection_qty" name="rejection_qty" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code">Penolakan Satuan</label>
                            <input type="text" class="form-control" id="rejection_unit" name="rejection_unit" readonly>

                            {{-- <select class="form-control" id="rejection_unit" name="rejection_unit" >
                                <option value="" selected disabled>-- Pilih Satuan --</option>
                                <option value="Lbr">Lbr</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Roll">Roll</option>
                            </select> --}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Sampling Qty</label>
                            <input type="number" class="form-control" id="example_qty" name="example_qty" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code">Sampling Satuan</label>
                            <input type="text" class="form-control" id="example_unit" name="example_unit" readonly>

                            {{-- <select class="form-control" id="example_unit" name="example_unit" >
                                <option value="" selected disabled>-- Pilih Satuan --</option>
                                <option value="Lbr">Lbr</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Roll">Roll</option>
                            </select> --}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="code">AQL <small class="text-danger">*</small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="aql" name="aql" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="code">AC/RC</label>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="ac_rc1" name="ac_rc1" >
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="ac_rc2" name="ac_rc2" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Keterangan <small class="text-danger">*</small></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
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
            $('#modalTitle').html('Tambah Return PM R1');
            $('.field-product').val('');
            $('.form-unit select').val('');
            $('#code_item').attr('readonly', false);

            ajaxGetStanding();
        }

        function ajaxGetStanding(){
            $.ajax({
                type : 'GET',
                url : '{{ url("data/standing") }}',
                dataType: 'json',
                success : function(res){
                    $('#out_standing_po_id').empty().append('<option value="" selected disabled>-- Pilih Nomor PO --</option>');
                    res.forEach(function(data){
                        $('#out_standing_po_id').append('<option value="'+data.id+'" data-po="'+data.no_po+'">'+data.no_po+'</option>');
                    });
                },
                error : function(err){
                   console.log(err)
                }
            });
        }

        
        function getProduct(){
            let po =$('#out_standing_po_id').find(":selected").attr('data-po');

            $.ajax({
                type : 'POST',
                url : '{{ url("data/po_standing") }}',
                data : {
                    "_token": "{{ csrf_token() }}",
                    "po" : po
                },
                success : function(res){
                    $('#item').val('');
                    $('#detail_products_id').empty().append('<option value="" selected disabled>-- Pilih Kode Barang --</option>');
                    res.forEach(function(data){
                        $('#detail_products_id').append('<option value="'+data.id+'" data-nama="'+data.item+'" data-supplier="'+data.supplier+'" data-unit="'+data.unit+'">'+data.code_item+'</option>');
                    });
                },
                error : function(err){
                   console.log(err)
                }
            });
        }

        function getProdSupName(){
            let product =$('#detail_products_id').find(":selected").attr('data-nama');
            let supplier =$('#detail_products_id').find(":selected").attr('data-supplier');
            let unit =$('#detail_products_id').find(":selected").attr('data-unit');

            $('#detail_products_name').val(product);
            $('#suppliers_name').val(supplier);
            $('#reception_unit, #rejection_unit, #example_unit').val(unit);
        }
    </script>

    @endpush

@endsection
