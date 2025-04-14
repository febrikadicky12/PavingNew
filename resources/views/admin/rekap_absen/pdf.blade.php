<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $month }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header-info {
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>REKAP ABSENSI KARYAWAN</h1>
    
    <div class="header-info">
        <p><strong>Periode:</strong> {{ Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceData as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data['nama'] }}</td>
                <td>{{ $data['hadir'] }}</td>
                <td>{{ $data['izin'] }}</td>
                <td>{{ $data['alpha'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y') }}</p>
        <p style="margin-top: 50px;">
            (________________________)<br>
            Manager HRD
        </p>
    </div>
</body>
</html>