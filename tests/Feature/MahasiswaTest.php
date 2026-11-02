<?php

namespace Tests\Feature;

use App\Models\mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    private function buat(int $nim = 220103095, string $nama = 'Budi', string $jurusan = 'Teknik Informatika'): void
    {
        mahasiswa::create(compact('nim', 'nama', 'jurusan'));
    }

    public function test_daftar_menampilkan_data(): void
    {
        $this->buat();
        $this->get('/mahasiswa')->assertOk()->assertSee('Budi')->assertSee('220103095');
    }

    public function test_pencarian_menyaring_nama_dan_tidak_memperlakukan_persen_sebagai_wildcard(): void
    {
        $this->buat(1, 'Budi');
        $this->buat(2, 'Siti', 'Sistem Informasi');
        $this->get('/mahasiswa?katakunci=Siti')->assertSee('Siti')->assertDontSee('Budi');
        $this->get('/mahasiswa?katakunci=%25')->assertDontSee('Budi')->assertDontSee('Siti');
    }

    public function test_tambah_data_tersimpan(): void
    {
        $this->post('/mahasiswa', ['nim' => 123, 'nama' => 'Ani', 'jurusan' => 'SI'])->assertRedirect('mahasiswa');
        $this->assertDatabaseHas('mahasiswa', ['nim' => 123, 'nama' => 'Ani']);
    }

    public function test_validasi_menolak_data_salah_dan_nim_ganda(): void
    {
        $this->buat(123);
        $this->post('/mahasiswa', ['nim' => 123, 'nama' => 'Ani', 'jurusan' => 'SI'])->assertSessionHasErrors('nim');
        $this->post('/mahasiswa', ['nim' => 'abc', 'nama' => 'Ani', 'jurusan' => 'SI'])->assertSessionHasErrors('nim');
        $this->post('/mahasiswa', ['nim' => 99999999999, 'nama' => 'Ani', 'jurusan' => 'SI'])->assertSessionHasErrors('nim');
        $this->post('/mahasiswa', ['nim' => 5, 'nama' => '', 'jurusan' => ''])->assertSessionHasErrors(['nama', 'jurusan']);
    }

    public function test_halaman_ubah_menuju_alamat_yang_benar_dan_perubahan_tersimpan(): void
    {
        $this->buat(123);
        $this->get('/mahasiswa/123/edit')->assertOk()->assertSee(url('mahasiswa/123'), false);
        $this->put('/mahasiswa/123', ['nama' => 'Baru', 'jurusan' => 'SI'])->assertRedirect('mahasiswa');
        $this->assertDatabaseHas('mahasiswa', ['nim' => 123, 'nama' => 'Baru']);
    }

    public function test_nim_tidak_dikenal_menghasilkan_404(): void
    {
        $this->get('/mahasiswa/999/edit')->assertNotFound();
        $this->put('/mahasiswa/999', ['nama' => 'X', 'jurusan' => 'Y'])->assertNotFound();
    }

    public function test_hapus_data(): void
    {
        $this->buat(123);
        $this->delete('/mahasiswa/123')->assertRedirect('mahasiswa');
        $this->assertDatabaseMissing('mahasiswa', ['nim' => 123]);
    }

    public function test_rekap_menghitung_per_jurusan(): void
    {
        $this->buat(1, 'A', 'Teknik Informatika');
        $this->buat(2, 'B', 'Teknik Informatika');
        $this->buat(3, 'C', 'Sistem Informasi');
        $this->get('/mahasiswa/rekap')->assertOk()->assertSeeInOrder(['Teknik Informatika', '2', '66,7%', 'Sistem Informasi', '1', '33,3%']);
    }

    public function test_excel_berisi_judul_kolom_dan_data(): void
    {
        $this->buat(123, 'Ani', 'SI');
        $r = $this->get('/mahasiswa/export/excel')->assertOk();
        $berkas = $r->baseResponse->getFile()->getPathname();
        $lembar = \PhpOffice\PhpSpreadsheet\IOFactory::load($berkas)->getActiveSheet();
        $this->assertSame(['NIM', 'Nama', 'Jurusan'], $lembar->rangeToArray('A1:C1')[0]);
        $this->assertEquals([123, 'Ani', 'SI'], $lembar->rangeToArray('A2:C2')[0]);
    }

    public function test_pdf_memuat_semua_data_melewati_batas_halaman(): void
    {
        foreach (range(1, 40) as $i) {
            $this->buat($i, 'Mhs' . $i, 'SI');
        }
        $this->get('/mahasiswa')->assertSee('Mhs40')->assertDontSee('Mhs1<', false);
        $r = $this->get('/mahasiswa/download/pdf')->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $r->getContent());
    }
}
