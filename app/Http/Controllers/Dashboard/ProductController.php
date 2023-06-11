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
        $request['orderBy'] = $request->orderBy ?? 'name'; // Atur default orderBy
        $request['orderType'] = $request->orderType ?? 'asc'; // Atur default orderType

        $data['categories'] = $this->categoryService->all(); // Ambil data hak akses
        $data['products'] = $this->productService->getProductsWithCategoryName($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.product.index', $data); // Tampilkan halaman jenis barang
    }

    public function create()
    {
        $data['categories'] = $this->categoryService->all(); // Ambil data hak akses

        return view('dashboard.product.create', $data); // Tampilkan halaman tambah jenis barang
    }

    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->productService->create($request->except('_token')); // Buat data jenis barang

            DB::commit();

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil menambahkan data'); // Redirect ke halaman jenis barang
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['product'] = $this->productService->findOrFail($id); // Ambil data jenis barang berdasarkan id
        $data['categories'] = $this->categoryService->all(); // Ambil data hak akses

        return view('dashboard.product.edit', $data); // Tampilkan halaman edit jenis barang
    }

    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $product = $this->productService->findOrFail($id); // Ambil data jenis barang berdasarkan id

            $product->update($request->except('_token')); // Buat data jenis barang

            DB::commit();

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil mengubah data'); // Redirect ke halaman jenis barang
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productService->delete($id); // Hapus data jenis barang

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil menghapus data'); // Redirect ke halaman jenis barang
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e); // Jika gagal, maka redirect ke halaman login dengan pesan error
        }
    }
}
