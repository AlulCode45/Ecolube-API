<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseApiController
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $category = $request->get('category');

            if ($category) {
                $data = $this->repository->getByCategory($category);
                return $this->successResponse($data);
            }

            $data = $this->repository->paginate($perPage);
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'brand' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product = $this->repository->create($data);
            return $this->createdResponse($product, 'Product created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->repository->find($id);
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $id,
            'description' => 'nullable|string',
            'category' => 'sometimes|required|string',
            'brand' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'unit' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $product = $this->repository->find($id);
            $data = $request->all();

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $updated = $this->repository->update($id, $data);
            return $this->successResponse($updated, 'Product updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->repository->find($id);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $this->repository->delete($id);
            return $this->successResponse(null, 'Product deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $this->repository->reorder($request->order);
            return $this->successResponse(null, 'Products reordered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function categories()
    {
        try {
            $categories = $this->repository->getCategories();
            return $this->successResponse($categories);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
