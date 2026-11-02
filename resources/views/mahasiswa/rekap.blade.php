@extends('layout.template')

@section('konten')
    <h1 class="xl-title" data-at-split>Rekap <em>jurusan</em></h1>

    <div class="xl-sheet" data-at>
        <table>
            <thead>
                <tr class="xl-cols" aria-hidden="true"><th></th><th>A</th><th>B</th><th>C</th><th>D</th></tr>
                <tr><th class="xl-n">1</th><th>Jurusan</th><th>Jumlah</th><th>Porsi</th><th>Grafik</th></tr>
            </thead>
            <tbody>
                @forelse ($rekap as $r)
                <tr>
                    <td class="xl-n">{{ $loop->iteration + 1 }}</td>
                    <td>{{ $r->jurusan }}</td>
                    <td class="xl-num">{{ $r->jumlah }}</td>
                    <td class="xl-num">{{ number_format($r->jumlah / $total * 100, 1, ',', '.') }}%</td>
                    <td class="xl-barcell"><i style="width:{{ round($r->jumlah / $rekap->max('jumlah') * 100) }}%"></i></td>
                </tr>
                @empty
                <tr><td colspan="5" class="xl-empty">Belum ada data.</td></tr>
                @endforelse
            </tbody>
            @if ($total)
            <tfoot><tr><td class="xl-n">{{ $rekap->count() + 2 }}</td><td class="xl-total">Total</td><td class="xl-num xl-total">{{ $total }}</td><td class="xl-num xl-total">100%</td><td></td></tr></tfoot>
            @endif
        </table>
    </div>
@endsection
