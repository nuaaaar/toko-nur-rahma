<?php

namespace App\Services\Bank;

use LaravelEasyRepository\Service;
use App\Repositories\Bank\BankRepository;

class BankServiceImplement extends Service implements BankService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(BankRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getBanks(string $orderBy, string $orderType, ?string $search, int $limit)
    {
        return $this->mainRepository->search($search)->orderData($orderBy, $orderType)->paginate($limit);
    }
}
