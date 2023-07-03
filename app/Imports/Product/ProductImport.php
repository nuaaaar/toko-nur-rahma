<?php

namespace App\Imports\Product;

use App\Imports\Product\Sheets\CleaningToolSheet;
use App\Imports\Product\Sheets\OfficeStationerySheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new OfficeStationerySheet(),
            new CleaningToolSheet(),
        ];
    }
}
