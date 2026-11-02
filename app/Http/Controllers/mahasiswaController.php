<?php

namespace App\Http\Controllers;

use App\Exports\ExportMahasiswa;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class mahasiswaController extends Controller
{
    private const PER_HALAMAN = 15;

    public function index(Request $request)
    {
        $katakunci = trim((string) $request->katakunci);
        $query = mahasiswa::query()->orderBy('nim', 'desc');

        if ($katakunci !== '') {
            $pola = '%' . addcslashes($katakunci, '%_\\') . '%';
            $query->where(function ($q) use ($pola) {
                $q->where('nim', 'like', $pola)
                    ->orWhere('nama', 'like', $pola)
                    ->orWhere('jurusan', 'like', $pola);
            });
        }

        return view('mahasiswa.index')->with('data', $query->paginate(self::PER_HALAMAN));
    }

    public function rekap()
    {
        $rekap = mahasiswa::select('jurusan', DB::raw('COUNT(*) AS jumlah'))
            ->groupBy('jurusan')
            ->orderByDesc('jumlah')
            ->orderBy('jurusan')
            ->get();

        return view('mahasiswa.rekap', ['rekap' => $rekap, 'total' => $rekap->sum('jumlah')]);
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        Session::flash('nim', $request->nim);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);
        $data = $request->validate([
            'nim' => 'required|integer|min:1|max:2147483647|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'nim.integer' => 'NIM wajib dalam angka',
            'nim.min' => 'NIM tidak valid',
            'nim.max' => 'NIM terlalu panjang',
            'nim.unique' => 'NIM yang diisikan sudah ada dalam database',
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ]);
        mahasiswa::create($data);

        return redirect()->to('mahasiswa')->with('success', 'Berhasil menambahkan data');
    }

    public function edit(string $id)
    {
        $data = mahasiswa::where('nim', $id)->firstOrFail();

        return view('mahasiswa.edit')->with('data', $data);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ]);
        mahasiswa::where('nim', $id)->firstOrFail();
        mahasiswa::where('nim', $id)->update($data);

        return redirect()->to('mahasiswa')->with('success', 'Berhasil mengupdate data');
    }

    public function destroy(string $id)
    {
        mahasiswa::where('nim', $id)->delete();

        return redirect('mahasiswa')->with('success', 'Berhasil menghapus data');
    }

    public function view_pdf()
    {
        return $this->pdf('I');
    }

    public function download_pdf()
    {
        return $this->pdf('D');
    }

    /* Semua data dicetak, bukan hanya halaman yang sedang tampil */
    private function pdf(string $mode)
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('framework/cache')]);
        $mpdf->SetTitle('Laporan Data Mahasiswa');
        $mpdf->SetFooter('Laporan Data Mahasiswa||Halaman {PAGENO} dari {nbpg}');
        $mpdf->WriteHTML(view('mahasiswa.pdf', [
            'data' => mahasiswa::orderBy('nim', 'desc')->get(),
            'tanggal' => now()->format('d/m/Y H:i'),
        ])->render());
        $isi = $mpdf->Output('', 'S');
        $posisi = $mode === 'D' ? 'attachment' : 'inline';

        return response($isi, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $posisi . '; filename="laporan-mahasiswa.pdf"',
        ]);
    }

    public function export_excel()
    {
        return Excel::download(new ExportMahasiswa, 'mahasiswa.xlsx');
    }
}
