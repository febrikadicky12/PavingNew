<!-- resources/views/admin/totalproduksi/print.blade.php -->
@extends('layouts.master')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Total Produksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin-bottom: 5px;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
        }
        .signature {
            float: right;
            text-align: center;
            width: 200px;
        }
        .signature p {
            margin-top: 70px;
        }
        .date {
            text-align: right;
            margin-bottom: 50px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>CV. PAPING NUSANTARA</h2>
        <p>Laporan Total Produksi</p>
        <p>Periode: {{ date('d-m-Y', strtotime($startDate)) }} s/d {{ date('d-m-Y', strtotime($endDate)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Status</th>
                <th>Periode</th>
                <th>Gaji</th>
                <th>Total Item Produksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($report as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->karyawan->nama }}</td>
                    <td>{{ $item->karyawan->status }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->periode_produksi)) }}</td>
                    <td>{{ $item->gaji ? 'Rp ' . number_format($item->gaji->jumlah_gaji, 0, ',', '.') : '-' }}</td>
                    <td>{{ number_format($item->total_items, 0, ',', '.') }} item</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data produksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align: right;">Total:</th>
                <th>Rp {{ number_format($report->sum(function($item) { 
                    return $item->gaji ? $item->gaji->jumlah_gaji : 0; 
                }), 0, ',', '.') }}</th>
                <th>{{ number_format($report->sum('total_items'), 0, ',', '.') }} item</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="date">
            <p>{{ date('d F Y') }}</p>
        </div>
        <div class="signature">
            <p>Manager</p>
            <p>_________________</p>
        </div>
    </div>
</body>
</html>
@endsection