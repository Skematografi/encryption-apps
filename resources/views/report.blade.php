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
                        <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('printReport')}}" method="POST" target="_blank" class="form-inline" autocomplete="off">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="code" class="mr-3">Nomor PO : </label>
                        <input type="text" class="form-control mr-3" id="no_po" name="no_po" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="code" class="mr-3">Tanggal : </label>
                        <input type="text" class="form-control mr-3 datepicker" id="date" name="date" placeholder="dd-mm-yyyy" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-warning"><i
                            class="fas fa-download fa-sm text-white-50"></i> Cetak Form Return</button>
                    </div>
                </form>
                <hr>
                <div class="table-responsive mt-5">
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
                                <th rowspan="2">STATUS</th>
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
                                    <td>
                                        @if ($item['print'] == 1)
                                            <span class="badge badge-success">Sudah Dicetak</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Dicetak</span>
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


    @push('script')

    <script>
       
    </script>

    @endpush

@endsection
