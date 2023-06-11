<?php

namespace App\Services\CustomerReturnItem;

use LaravelEasyRepository\Service;
use App\Repositories\CustomerReturnItem\CustomerReturnItemRepository;

class CustomerReturnItemServiceImplement extends Service implements CustomerReturnItemService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CustomerReturnItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function insertCustomerReturnItems(array $items, int $customerReturn)
    {
        $items = array_map(function($item) use ($customerReturn){
            $item['customer_return_id'] = $customerReturn;
            $item['created_at'] = now();
            $item['updated_at'] = now();

            return $item;
        }, $items);

        return $this->mainRepository->insert($items);
    }

    public function updateCustomerReturnItems(array $items, int $customerReturnId)
    {
        $this->mainRepository->deleteByCustomerReturnId($customerReturnId);

        return $this->insertCustomerReturnItems($items, $customerReturnId);
    }
}
