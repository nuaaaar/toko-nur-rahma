<?php

namespace App\Services\Customer;

use LaravelEasyRepository\Service;
use App\Repositories\Customer\CustomerRepository;

class CustomerServiceImplement extends Service implements CustomerService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CustomerRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getCustomers(string $orderBy, string $orderType, ?string $search, int $limit)
    {
        $query = $this->mainRepository->search($search)->orderData($orderBy, $orderType);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    public function updateOrCreateCustomer(array $data)
    {
        $customer = $this->mainRepository->findByPhoneNumber($data['phone_number']);

        if ($customer) {
            $customer->update($data);
        } else {
            $customer = $this->mainRepository->create($data);
        }

        return $customer;
    }
}
