<?php

namespace App\Exports\Procurement\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProcurementSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $procurements;

    public function __construct($procurements)
    {
        $this->procurements = $procurements;
    }

    public function view(): View
    {
        return view('exports.procurement.procurement', [
            'procurements' => $this->procurements
        ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal Pengadaan',
            'No. Invoice Agen',
            'Nama Agen',
            'NPWP Agen',
            'Pajak(%)',
            'Total'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '0,000',
        ];
    }
}
