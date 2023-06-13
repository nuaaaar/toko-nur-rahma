<?php

namespace App\Imports\Product;

use App\Imports\Product\Sheets\CleaningToolSheet;
use App\Imports\Product\Sheets\OfficeStationerySheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductImport implements WithMultipleSheets
{
    protected $existingProductCodes;

    public function __construct(array $existingProductCodes)
    {
        $this->existingProductCodes = $existingProductCodes;
    }

    public function sheets(): array
    {
        return [
            new OfficeStationerySheet($this->existingProductCodes),
            new CleaningToolSheet($this->existingProductCodes),
        ];
    }
}
