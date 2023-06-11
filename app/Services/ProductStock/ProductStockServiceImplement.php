<?php

namespace App\Services\ProductStock;

use App\Repositories\Product\ProductRepository;
use LaravelEasyRepository\Service;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Traits\DateTrait;

class ProductStockServiceImplement extends Service implements ProductStockService{

    use DateTrait;
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    protected $productRepository;

    public function __construct(ProductStockRepository $mainRepository, ProductRepository $productRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->productRepository = $productRepository;
    }

    // Define your custom methods :)

    public function upsertProductStocksFromEveryProductByDate(string $transaction, ?string $oldStartDate, string $newStartDate, ?array $oldItems, ?array $newItems)
    {
        $dates = $this->getDates($newStartDate, now());
        $productIds = array_unique(array_merge(array_column($oldItems ?? [], 'product_id'), array_column($newItems ?? [], 'product_id')));

        $productStocks = $this->mainRepository->getProductStockFromEveryProductByDates($productIds, $dates);
        $oldProductStocks = $this->mainRepository->getLatestProductStockFromEveryProductByDate($productIds, $newStartDate);

        $newProductStocks = [];
        foreach($productIds as $productId)
        {
            foreach($dates as $date)
            {
                $currentDateProductStock = $productStocks->where('product_id', $productId)->where('date', $date)->first();
                $olderDateProductStock = $oldProductStocks->where('product_id', $productId)->where('date', '<=', $date)->sortByDesc('date')->first();

                $newItem = collect($newItems)->where('product_id', $productId)->first();
                $oldItem = collect($oldItems)->where('product_id', $productId)->first();
                $changes = $oldStartDate != null && $oldStartDate != $newStartDate ? ($newItem['qty'] ?? 0) : ($newItem['qty'] ?? 0) - ($oldItem['qty'] ?? 0);

                $newProductStock = [
                    'product_id' => $productId,
                    'date' => $date,
                    'stock' => $currentDateProductStock['stock'] ?? ($olderDateProductStock['stock'] ?? 0),
                    'delivery_order' => $currentDateProductStock['delivery_order'] ?? 0,
                    'procurement' => $currentDateProductStock['procurement'] ?? 0,
                    'sale' => $currentDateProductStock['sale'] ?? 0,
                    'return' => $currentDateProductStock['return'] ?? 0,
                    'change' => $currentDateProductStock['change'] ?? 0,
                ];
                $newProductStock['stock'] = $this->calculateStock($newProductStock['stock'], $changes, $transaction);

                if($date == $newStartDate) $newProductStock[$transaction] += $changes;

                if($date == $newStartDate || $currentDateProductStock) array_push($newProductStocks, $newProductStock);
            }
        }

        $this->mainRepository->upsert($newProductStocks, ['product_id', 'date'], ['stock', 'delivery_order', 'procurement', 'sale', 'return', 'change']);

        if ($oldStartDate != null && $oldStartDate != $newStartDate) $this->upsertProductStocksFromEveryProductByDate($transaction, null, $oldStartDate, $oldItems, null);
    }

    public function getProductStocksBetweenDates(array $productIds, string $startDate, string $endDate, string $orderBy, string $orderDirection, ?array $filters, ?string $search)
    {
        $dates = $this->getDates($startDate, $endDate);
        $olderDateProductStocks = $this->mainRepository->getLatestProductStockFromEveryProductByDate($productIds, $startDate);
        $products = $this->productRepository->joinCategoryName()->getProductWithProductStocksBetweenDates($productIds, $startDate, $endDate)->filter($filters)->search($search)->orderData($orderBy, $orderDirection)->get();

        foreach ($products as $key => $product) {
            $productStocks = $product->productStocks->keyBy('date');
            $filledProductStocks = [];

            foreach ($dates as $date) {
                $olderDateProductStock = $olderDateProductStocks->where('product_id', $product->id)->where('date', '<=', $date)->sortByDesc('date')->first();
                $currentDateProductStock = $productStocks[$date] ?? null;
                $beforeDateProductStock = $filledProductStocks[count($filledProductStocks) - 1] ?? $productStocks[date('Y-m-d', strtotime($date . ' -1 day'))] ?? null;

                $productStock = [
                    'product_id' => $product->id,
                    'date' => $date,
                    'stock' => $currentDateProductStock['stock'] ?? $beforeDateProductStock['stock'] ?? $olderDateProductStock['stock'] ?? 0,
                    'delivery_order' => $currentDateProductStock['delivery_order'] ?? 0,
                    'procurement' => $currentDateProductStock['procurement'] ?? 0,
                    'sale' => $currentDateProductStock['sale'] ?? 0,
                    'return' => $currentDateProductStock['return'] ?? 0,
                    'change' => $currentDateProductStock['change'] ?? 0,
                ];

                array_push($filledProductStocks, $productStock);
            }
            $products[$key]->filled_product_stocks = $filledProductStocks;

        }

        return $products;
    }

    protected function calculateStock(int $stock, int $qty, string $transaction)
    {
        $transactionType = $this->getTransactionType($transaction);

        return $transactionType == 'in' ? $stock + $qty : $stock - $qty;
    }

    protected function getTransactionType(string $transaction)
    {
        $transactionTypes = [
            'delivery_order' => 'out',
            'procurement' => 'in',
            'sale' => 'out',
            'return' => 'in',
            'change' => 'out',
        ];

        return $transactionTypes[$transaction];
    }
}
