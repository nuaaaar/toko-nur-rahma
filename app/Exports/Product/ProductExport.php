<?php

namespace App\Exports\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    public function view(): View
    {
        $data['products'] = Product::with('category')->get();

        return view('exports.product.product', $data);
    }

    public function headings(): array
    {
        return [
            'Kode Produk',
            'Barcode (Agen)',
            'Nama Produk',
            'Satuan',
            'Kategori',
            'Harga Modal',
            'Harga Jual',
            'Diperbarui Pada'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '0,000',
            'G' => '0,000',
        ];
    }
}
