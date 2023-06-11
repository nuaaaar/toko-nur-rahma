<?php

namespace App\Services\Procurement;

use LaravelEasyRepository\Service;
use App\Repositories\Procurement\ProcurementRepository;

class ProcurementServiceImplement extends Service implements ProcurementService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ProcurementRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getProcurementsWithSupplierAndItems(?string $orderBy = 'date', ?string $orderType = 'asc', ?array $filters = [], ?string $search = null, ?int $limit = 10)
    {
        return $this->mainRepository->joinSupplier()->withRelations(['procurementItems.product'])->filter($filters)->search($search)->orderData($orderBy, $orderType)->paginate($limit);
    }

    public function create($data)
    {
        return $this->mainRepository->create($data);
    }

    public function findById($id)
    {
        return $this->mainRepository->withRelations(['procurementItems'])->findOrFail($id);
    }
}
