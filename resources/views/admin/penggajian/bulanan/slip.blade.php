<!-- resources/views/admin/penggajian/bulanan/slip.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $penggajian->karyawan->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
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
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th {
            text-align: left;
            width: 40%;
            padding: 8px 5px;
        }
        .info-table td {
            padding: 8px 5px;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .salary-table th, .salary-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .salary-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SLIP GAJI KARYAWAN</h2>
        <h3>Periode: {{ $penggajian->periode_gaji->format('F Y') }}</h3>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <th>Nama Karyawan</th>
                <td>: {{ $penggajian->karyawan->nama }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>: {{ $penggajian->karyawan->jabatan }}</td>
            </tr>
            <tr>
                <th>Status Karyawan</th>
                <td>: Bulanan</td>
            </tr>
            <tr>
                <th>Tanggal Penggajian</th>
                <td>: {{ $penggajian->tgl_penggajian->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <h4>Data Kehadiran:</h4>
        <table class="info-table">
            <tr>
                <th>Jumlah Hadir</th>
                <td>: {{ $penggajian->rekapAbsen->jumlah_hadir }} hari</td>
            </tr>
            <tr>
                <th>Jumlah Izin</th>
                <td>: {{ $penggajian->rekapAbsen->jumlah_izin }} hari</td>
            </tr>
            <tr>
                <th>Jumlah Alpa</th>
                <td>: {{ $penggajian->rekapAbsen->jumlah_alpa }} hari</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <h4>Rincian Gaji:</h4>
        <table class="salary-table">
            <tr>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>Gaji Pokok ({{ $penggajian->gaji->nama_gaji }})</td>
                <td>Rp {{ number_format($penggajian->gaji->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            @if ($penggajian->gaji->potongan_izin > 0 && $penggajian->rekapAbsen->jumlah_izin > 0)
            <tr>
                <td>Potongan Izin ({{ $penggajian->rekapAbsen->jumlah_izin }} hari x Rp {{ number_format($penggajian->gaji->potongan_izin, 0, ',', '.') }})</td>
                <td>- Rp {{ number_format($penggajian->gaji->potongan_izin * $penggajian->rekapAbsen->jumlah_izin, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if ($penggajian->gaji->potongan_alpa > 0 && $penggajian->rekapAbsen->jumlah_alpa > 0)
            <tr>
                <td>Potongan Alpa ({{ $penggajian->rekapAbsen->jumlah_alpa }} hari x Rp {{ number_format($penggajian->gaji->potongan_alpa, 0, ',', '.') }})</td>
                <td>- Rp {{ number_format($penggajian->gaji->potongan_alpa * $penggajian->rekapAbsen->jumlah_alpa, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total Gaji Diterima</td>
                <td>Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>{{ now()->format('d F Y') }}</p>
        <div class="signature">
            <p>____________________</p>
            <p>Manager Keuangan</p>
        </div>
    </div>
</body>
</html>