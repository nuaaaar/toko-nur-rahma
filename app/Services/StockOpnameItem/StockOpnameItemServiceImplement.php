<?php

namespace App\Services\StockOpnameItem;

use LaravelEasyRepository\Service;
use App\Repositories\StockOpnameItem\StockOpnameItemRepository;

class StockOpnameItemServiceImplement extends Service implements StockOpnameItemService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(StockOpnameItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function insertStockOpnameItems(array $items, int $stockOpname)
    {
        $items = array_map(function($item) use ($stockOpname){
            $item['stock_opname_id'] = $stockOpname;
            $item['difference'] = ($item['physical'] + $item['returned_to_supplier']) - $item['system'];
            $item['created_at'] = now();
            $item['updated_at'] = now();

            return $item;
        }, $items);

        return $this->mainRepository->insert($items);
    }

    public function updateStockOpnameItems(array $items, int $stockOpnameId)
    {
        $this->mainRepository->deleteByStockOpnameId($stockOpnameId);

        return $this->insertStockOpnameItems($items, $stockOpnameId);
    }
}
