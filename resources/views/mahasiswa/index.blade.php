@extends('layout.template')

@section('konten')
    <h1 class="xl-title" data-at-split>Data <em>mahasiswa</em></h1>

    <div class="xl-ribbon" data-at>
        <a class="xl-btn xl-btn--main" href="{{ url('mahasiswa/create') }}">Tambah baris</a>
        <a class="xl-btn" href="{{ url('mahasiswa/view/pdf') }}" data-no-at target="_blank" rel="noopener">Lihat PDF</a>
        <a class="xl-btn" href="{{ url('mahasiswa/download/pdf') }}" data-no-at>Unduh PDF</a>
        <a class="xl-btn" href="{{ url('mahasiswa/export/excel') }}" data-no-at>Unduh Excel</a>
    </div>

    <form class="xl-formula" action="{{ url('mahasiswa') }}" method="get" data-at>
        <label for="katakunci"><i>fx</i></label>
        <input type="search" id="katakunci" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="=CARI(&quot;nim, nama, atau jurusan&quot;)" aria-label="Cari data">
        <button type="submit">Cari</button>
    </form>

    <div class="xl-sheet" data-at>
        <table>
            <thead>
                <tr class="xl-cols" aria-hidden="true"><th></th><th>A</th><th>B</th><th>C</th><th>D</th><th>E</th></tr>
                <tr><th class="xl-n">1</th><th>No</th><th>NIM</th><th>Nama</th><th>Jurusan</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td class="xl-n">{{ $loop->iteration + 1 }}</td>
                    <td>{{ $data->firstItem() + $loop->index }}</td>
                    <td class="xl-num">{{ $item->nim }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jurusan }}</td>
                    <td class="xl-act">
                        <a href="{{ url('mahasiswa/'.$item->nim.'/edit') }}">Ubah</a>
                        <form onsubmit="return confirm('Yakin mau menghapus data?')" action="{{ url('mahasiswa/'.$item->nim) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="xl-empty">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="xl-pages">{{ $data->withQueryString()->links('pagination::simple-default') }}</div>
@endsection
