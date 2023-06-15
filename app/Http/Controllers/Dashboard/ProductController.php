<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use DB;
use Log;
use Throwable;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;

        $this->middleware(['permission:products.read'], ['only' => ['index']]);
        $this->middleware(['permission:products.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:products.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:products.delete'], ['only' => ['destroy']]);    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name';
        $request['orderType'] = $request->orderType ?? 'asc';

        $data['categories'] = $this->categoryService->all();
        $data['products'] = $this->productService->getProductsWithCategoryName($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.product.index', $data);
    }

    public function create()
    {
        $data['categories'] = $this->categoryService->all();

        return view('dashboard.product.create', $data);
    }

    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->productService->create($request->except('_token'));

            DB::commit();

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil menambah data');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['product'] = $this->productService->findOrFail($id);
        $data['categories'] = $this->categoryService->all();

        return view('dashboard.product.edit', $data);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $product = $this->productService->findOrFail($id);

            $product->update($request->except('_token'));

            DB::commit();

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil mengubah data');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productService->delete($id);

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil menghapus data');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e);
        }
    }
}
