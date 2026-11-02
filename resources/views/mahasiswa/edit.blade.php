@extends('layout.template')

@section('konten')
<h1 class="xl-title" data-at-split>Ubah <em>baris</em></h1>
<form class="xl-form" action="{{ url('mahasiswa/'.$data->nim) }}" method="post" data-at>
    @csrf
    @method('PUT')
    <div class="xl-field"><label><i>A</i>NIM</label><input type="text" value="{{ $data->nim }}" readonly></div>
    <div class="xl-field"><label for="nama"><i>B</i>Nama</label><input type="text" name="nama" id="nama" value="{{ $data->nama }}"></div>
    <div class="xl-field"><label for="jurusan"><i>C</i>Jurusan</label><input type="text" name="jurusan" id="jurusan" value="{{ $data->jurusan }}"></div>
    <div class="xl-ribbon"><button type="submit" class="xl-btn xl-btn--main" name="submit">Simpan</button><a class="xl-btn" href="{{ url('mahasiswa') }}">Kembali</a></div>
</form>
@endsection
