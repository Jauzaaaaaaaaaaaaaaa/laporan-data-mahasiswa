@extends('layout.template')

@section('konten')
<h1 class="xl-title" data-at-split>Tambah <em>baris</em></h1>
<form class="xl-form" action="{{ url('mahasiswa') }}" method="post" data-at>
    @csrf
    <div class="xl-field"><label for="nim"><i>A</i>NIM</label><input type="number" name="nim" id="nim" value="{{ Session::get('nim') }}"></div>
    <div class="xl-field"><label for="nama"><i>B</i>Nama</label><input type="text" name="nama" id="nama" value="{{ Session::get('nama') }}"></div>
    <div class="xl-field"><label for="jurusan"><i>C</i>Jurusan</label><input type="text" name="jurusan" id="jurusan" value="{{ Session::get('jurusan') }}"></div>
    <div class="xl-ribbon"><button type="submit" class="xl-btn xl-btn--main" name="submit">Simpan</button><a class="xl-btn" href="{{ url('mahasiswa') }}">Kembali</a></div>
</form>
@endsection
