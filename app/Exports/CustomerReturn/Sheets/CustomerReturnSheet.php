<?php

namespace App\Exports\CustomerReturn\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerReturnSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $customerReturns;

    public function __construct($customerReturns)
    {
        $this->customerReturns = $customerReturns;
    }

    public function view(): View
    {
        return view('exports.customer-return.customer-return', [
            'customer_returns' => $this->customerReturns
        ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal Retur',
            'No. Invoice Retur',
            'No. Invoice Penjualan',
            'Nama Customer',
            'Nomor Telepon Customer',
            'Alamat Customer',
            'Total'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => '0,000',
        ];
    }
}
