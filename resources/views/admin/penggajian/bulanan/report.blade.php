<!-- resources/views/admin/penggajian/bulanan/report.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Gaji Bulanan - {{ $period }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2, .header h3 {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: black;
        }
        .summary {
            margin-top: 20px;
            float: right;
            border: 1px solid #ddd;
            padding: 10px;
            width: 250px;
        }
        .summary-table {
            width: 100%;
            border: none;
        }
        .summary-table td, .summary-table th {
            border: none;
            padding: 3px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN GAJI KARYAWAN BULANAN</h2>
      <!-- To this -->
<h3>Periode: {{ \Carbon\Carbon::createFromFormat('Y-m', $period)->format('F Y') }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th class="text-center">Hadir</th>
                <th class="text-center">Izin</th>
                <th class="text-center">Alpa</th>
                <th>Gaji Pokok</th>
                <th>Total Potongan</th>
                <th>Gaji Diterima</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $sudahBayar = 0; $belumBayar = 0; @endphp
            @forelse ($penggajian as $index => $gaji)
            @php 
                $total += $gaji->total_gaji;
                $potonganIzin = $gaji->gaji->potongan_izin * $gaji->rekapAbsen->jumlah_izin;
                $potonganAlpa = $gaji->gaji->potongan_alpa * $gaji->rekapAbsen->jumlah_alpa;
                $totalPotongan = $potonganIzin + $potonganAlpa;
                
                if ($gaji->status_penggajian == 'sudah bayar') {
                    $sudahBayar++;
                } else {
                    $belumBayar++;
                }
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $gaji->karyawan->nama }}</td>
                <td>{{ $gaji->karyawan->jabatan }}</td>
                <td class="text-center">{{ $gaji->rekapAbsen->jumlah_hadir }}</td>
                <td class="text-center">{{ $gaji->rekapAbsen->jumlah_izin }}</td>
                <td class="text-center">{{ $gaji->rekapAbsen->jumlah_alpa }}</td>
                <td class="text-right">Rp {{ number_format($gaji->gaji->gaji_pokok, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if ($gaji->status_penggajian == 'sudah bayar')
                    <span class="badge badge-success">Sudah Bayar</span>
                    @else
                    <span class="badge badge-warning">Belum Dibayar</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Tidak ada data penggajian untuk periode ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <table class="summary-table">
            <tr>
                <th>Total Karyawan</th>
                <td class="text-right">{{ count($penggajian) }} orang</td>
            </tr>
            <tr>
                <th>Sudah Dibayar</th>
                <td class="text-right">{{ $sudahBayar }} orang</td>
            </tr>
            <tr>
                <th>Belum Dibayar</th>
                <td class="text-right">{{ $belumBayar }} orang</td>
            </tr>
            <tr>
                <th>Total Gaji</th>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>{{ now()->format('d F Y') }}</p>
        <div class="signature">
            <p>____________________</p>
            <p>Manager Keuangan</p>
        </div>
    </div>
</body>
</html>