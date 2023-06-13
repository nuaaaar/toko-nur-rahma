<?php

namespace App\Imports\Product\Sheets;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OfficeStationerySheet implements ToModel, WithHeadingRow, WithChunkReading
{
    protected $category;

    protected $existingProductCodes;

    public function __construct(array $existingProductCodes)
    {
        $this->existingProductCodes = $existingProductCodes;
        $this->category = Category::where('name', 'ATK')->first();
    }

    public function model(array $row)
    {
        if(in_array($row['kode_barang'], $this->existingProductCodes)){
            return null;
        }
        return new Product([
            'product_code' => $row['kode_barang'],
            'barcode' => $row['barcode'],
            'name' => $row['nama_barang'],
            'unit' => $row['satuan'],
            'capital_price' => str_replace('.', '', $row['harga_modal']),
            'selling_price' => str_replace('.', '', $row['harga_jual']),
            'category_id' => $this->category->id,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
