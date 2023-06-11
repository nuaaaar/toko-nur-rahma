<?php

namespace App\Services\StockOpname;

use LaravelEasyRepository\Service;
use App\Repositories\StockOpname\StockOpnameRepository;

class StockOpnameServiceImplement extends Service implements StockOpnameService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(StockOpnameRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getStockOpnames(string $orderBy, string $orderType, ?array $filters = [], ?string $search = null, ?int $limit = 10)
    {
        $query =  $this->mainRepository->withRelations(['stockOpnameItems.product', 'user'])->filter($filters)->search($search)->orderData($orderBy, $orderType);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    public function findById(int $id)
    {
        return $this->mainRepository->withRelations(['stockOpnameItems.product', 'user'])
                                    ->find($id);
    }

    public function create($data)
    {
        return $this->mainRepository->create($data);
    }
}
