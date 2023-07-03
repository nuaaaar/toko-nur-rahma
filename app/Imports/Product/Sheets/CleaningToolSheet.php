<?php

namespace App\Imports\Product\Sheets;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CleaningToolSheet implements ToModel, WithHeadingRow, WithChunkReading, WithUpserts
{
    protected $category;

    public function __construct()
    {
        $this->category = Category::where('name', 'ALAT KEBERSIHAN')->first();
    }

    public function model(array $row)
    {
        if($row['kode_barang'] == null){
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

    public function uniqueBy()
    {
        return ['product_code', 'deleted_identifier'];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
