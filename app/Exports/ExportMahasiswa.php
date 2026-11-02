<?php

namespace App\Exports;

use App\Models\mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportMahasiswa implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return mahasiswa::orderBy('nim', 'desc')->get();
    }

    public function headings(): array
    {
        return ['NIM', 'Nama', 'Jurusan'];
    }

    public function map($row): array
    {
        return [$row->nim, $row->nama, $row->jurusan];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->freezePane('A2');

        return [1 => ['font' => ['bold' => true]]];
    }
}
