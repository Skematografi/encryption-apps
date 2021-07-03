<style>
    table {
        font-size: 14px;
    }

    b {
        font-size: 10px;
    }

    img{
        width: 70px;
    }

    .col {
        float: left;
        padding: 10px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

{{-- <img src="{{ asset('img/logo-mayora-bw.png') }}" alt=""> --}}
<div class="row">
    <div class="col">
        <img src="{{ public_path('img/logo-mayora-bw.png') }}" alt="">
    </div>
    <div class="col">
        <b>PT. MAYORA INDAH Tbk - JAYANTI 2</b><br>
        <b>DEPT. QUALITY CONTROL</b>
    </div>
</div>

<h3 style="text-align: center; margin-top:30px; margin-bottom:20px;">FORM RETURN PACKAGING MATERIAL</h3>

<table>
    <tr>
        <td style="width: 180px;">Hari, Tanggal</td>
        <td style="width: 10px;">:</td>
        @php
            $hari = date ("D");
        
            switch($hari){
                case 'Sun':
                    $hari_ini = "Minggu";
                break;
        
                case 'Mon':			
                    $hari_ini = "Senin";
                break;
        
                case 'Tue':
                    $hari_ini = "Selasa";
                break;
        
                case 'Wed':
                    $hari_ini = "Rabu";
                break;
        
                case 'Thu':
                    $hari_ini = "Kamis";
                break;
        
                case 'Fri':
                    $hari_ini = "Jumat";
                break;
        
                case 'Sat':
                    $hari_ini = "Sabtu";
                break;
                
                default:
                    $hari_ini = "Tidak di ketahui";		
                break;
            }
        @endphp
        <td style="width: 150px;">{{ $hari_ini.', '.date('d/m/Y') }}</td>
        <td style="width: 70px;">AQL</td>
        <td style="width: 10px;">:</td>
        <td>{{ $returns[0]['aql'] }} %</td>
    </tr>
    <tr>
        <td style="width: 150px;">Divisi/Plant</td>
        <td style="width: 10px;">:</td>
        <td colspan="4">Wafer</td>
    </tr>
    <tr>
        <td style="width: 150px;">Jenis Reject</td>
        <td style="width: 10px;">:</td>
        <td colspan="4">R1</td>
    </tr>
</table>

<table width="100%" cellspacing="0" style="margin-top:25px;" border="1">
    <thead style="text-align:center;">
        <tr>
            <th rowspan="2">NO.</th>
            <th rowspan="2">SUPPLIER</th>
            <th rowspan="2">NO. PO</th>
            <th rowspan="2">NAMA RM/PM</th>
            <th rowspan="1" colspan="2">JUMLAH</th>
            <th rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th rowspan="1">DITERIMA</th>
            <th rowspan="1">DITOLAK</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($returns as $item)
            <tr>
                <td style="text-align: center; padding:5px;">{{ $i++ }}</td>
                <td style="padding:5px;">{{ $item['supplier'] }}</td>
                <td style="text-align: center; padding:5px;">{{ $item['no_po'] }}</td>
                <td style="padding:5px;">{{ $item['item'] }}</td>

                <td style="text-align: center; padding:5px;">{{ $item['reception_qty'].' '.$item['reception_unit'] }}</td>
                <td style="text-align: center; padding:5px;">{{ $item['rejection_qty'].' '.$item['rejection_unit'] }}</td>

                <td style="padding:5px;">{{ $item['description'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table width="100%" cellspacing="0" style="padding: 10px; text-align:center;">
    <tr>
        <td style="width: 25%; height:150px;">QC INCOMING</td>
        <td style="width: 25%; height:150px;">PPIC</td>
        <td style="width: 25%; height:150px;">WAREHOUSE</td>
        <td style="width: 25%; height:150px;">PEMASOK</td>
    </tr>
    <tr>
        <td style="width: 25%;"><hr style="width: 130px;"></td>
        <td style="width: 25%;"><hr style="width: 130px;"></td>
        <td style="width: 25%;"><hr style="width: 130px;"></td>
        <td style="width: 25%;"><hr style="width: 130px;"></td>
    </tr>
</table>