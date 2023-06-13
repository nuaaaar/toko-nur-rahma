<?php

namespace App\Services\Product;

use LaravelEasyRepository\Service;
use App\Repositories\Product\ProductRepository;

class ProductServiceImplement extends Service implements ProductService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ProductRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getProductsWithCategoryName(string $orderBy, string $orderType, ?array $filters, ?string $search, int $limit)
    {
        $query = $this->mainRepository->joinCategoryName()->filter($filters)->search($search)->orderData($orderBy, $orderType);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    public function getAllProductsWithLatestStock(string $orderBy, string $orderType, ?array $filters, ?string $search, int $limit)
    {
        $query = $this->mainRepository->joinCategoryName()->withRelations(['latestProductStock'])->filter($filters)->search($search)->orderData($orderBy, $orderType);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    public function getEmptyStockProducts(string $orderBy, string $orderType, ?array $filters, ?string $search)
    {
        return $this->mainRepository->joinCategoryName()->withRelations(['latestProductStock', 'category'])->filter($filters)->search($search)->orderData($orderBy, $orderType)->get()->filter(function($product){
            return ($product->latestProductStock->stock ?? 0) <= 0;
        });
    }
}
