<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Data Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;1,6..72,400&family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('atelier/atelier.css') }}">
    <link rel="stylesheet" href="{{ asset('atelier/theme.css') }}">
    <script src="{{ asset('atelier/theme.js') }}"></script>
    <script src="{{ asset('atelier/atelier.js') }}"></script>
  </head>
  <body>
    <header class="xl-bar">
      <a class="xl-logo" href="{{ url('mahasiswa') }}"><i>X</i>Laporan_Mahasiswa.xlsx</a>
      <span class="xl-saved">Tersimpan</span>
    </header>
    <main class="xl-wrap">
      @include('komponen.pesan')
      @yield('konten')
    </main>
    <nav class="xl-tabs" aria-label="Lembar">
      <a href="{{ url('mahasiswa') }}" class="{{ request()->is('mahasiswa/rekap') ? '' : 'is-on' }}">Mahasiswa</a>
      <a href="{{ url('mahasiswa/rekap') }}" class="{{ request()->is('mahasiswa/rekap') ? 'is-on' : '' }}">Rekap</a>
      <i>Siap</i>
    </nav>
  </body>
</html>
