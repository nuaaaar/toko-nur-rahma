<?php

namespace App\Exports\StockOpname\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockOpnameSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $stockOpnames;

    public function __construct($stockOpnames)
    {
        $this->stockOpnames = $stockOpnames;
    }

    public function view(): View
    {
        return view('exports.stock-opname.stock-opname', [
            'stock_opnames' => $this->stockOpnames
        ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal SO',
            'Periode',
            'Judul',
            'Aktual',
            'Sistem',
            'Selisih',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '0',
            'E' => '0',
            'F' => '0',
        ];
    }
}
