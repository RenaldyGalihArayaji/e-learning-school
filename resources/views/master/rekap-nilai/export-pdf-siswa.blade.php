<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
        h2 { margin-bottom: 0; }
        .filter { margin-bottom: 10px; font-size: 12px; }
        .header { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="header">E-LEARNING <br>  SMA BUDI LUHUR YOGYAKARTA</div>
    <h2 style="text-align:center;">REKAPANAN NILAI SISWA</h2>
    <div class="filter">
        <strong>Filter:</strong><br>
        @if(request('mata_pelajaran_id'))
            Mata Pelajaran: {{ optional($pengumpulanTugas->first()->tugas->mataPelajaran ?? null)->nama_mata_pelajaran }}<br>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Mata Pelajaran</th>
                <th>Tugas</th>
                <th>Kelas</th>
                <th>Guru</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengumpulanTugas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ucwords($item->siswa->nama_lengkap) }}</td>
                    <td>{{ ucwords($item->tugas->mataPelajaran->nama_mata_pelajaran ?? '-') }}</td>
                    <td>{{ ucwords($item->tugas->judul ?? '-') }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ ucwords($item->tugas->mataPelajaran->guruPengampu->nama_lengkap ?? '-') }}</td>
                    <td>{{ $item->nilai }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
