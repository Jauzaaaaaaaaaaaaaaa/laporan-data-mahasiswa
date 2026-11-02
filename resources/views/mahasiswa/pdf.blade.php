<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<style>
  body { font-family: sans-serif; font-size: 10.5pt; color: #1c2422; }
  h1 { font-size: 18pt; margin: 0; color: #0a5a32; }
  p { margin: 2pt 0 12pt; color: #62706b; }
  table { width: 100%; border-collapse: collapse; }
  th { background: #0f7b45; color: #fff; text-align: left; padding: 6pt 8pt; }
  td { padding: 5pt 8pt; border-bottom: 0.5pt solid #d8dee0; }
  tr:nth-child(even) td { background: #f3f5f5; }
</style>
</head>
<body>
  <h1>Laporan Data Mahasiswa</h1>
  <p>Dicetak {{ $tanggal }}. Total {{ $data->count() }} mahasiswa.</p>
  <table>
    <thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Jurusan</th></tr></thead>
    <tbody>
      @foreach ($data as $item)
      <tr><td>{{ $loop->iteration }}</td><td>{{ $item->nim }}</td><td>{{ $item->nama }}</td><td>{{ $item->jurusan }}</td></tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
