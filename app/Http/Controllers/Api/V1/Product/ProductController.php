<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): array
    {
        return ProductResource::collection(Product::all())->resolve();
    }

    public function show(Product $product): array
    {
        return ProductResource::make($product)->resolve();
    }

    public function store(ProductRequest $request): array
    {
        $data = $request->validated();

        $product = Product::query()->create($data);

        return ProductResource::make($product)->resolve();
    }

    public function update(UpdateRequest $request, Product $product): array
    {
        $data = $request->validated();
    
        $product->update($data);
    
        return ProductResource::make($product)->resolve();
    }
    

    public function delete(Product $product): JsonResponse
    {
        if (!$product) {
            return response()->json(["message" => "Item not found"], 404);
        }
    
        $product->delete();
    
        return response()->json(["message" => "Delete successful"]);
    }
}
