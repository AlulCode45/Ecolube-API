<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BrandController extends BaseApiController
{
    protected $repository;

    public function __construct(BrandRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
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
            'description' => 'nullable|string',
            'type' => 'required|in:oil,parts,tire,battery,chemical',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $data = $request->all();

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('brands', 'public');
            }

            $brand = $this->repository->create($data);
            return $this->createdResponse($brand, 'Brand created successfully');
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
            'description' => 'nullable|string',
            'type' => 'sometimes|required|in:oil,parts,tire,battery,chemical',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $brand = $this->repository->find($id);
            $data = $request->all();

            if ($request->hasFile('logo')) {
                if ($brand->logo) {
                    Storage::disk('public')->delete($brand->logo);
                }
                $data['logo'] = $request->file('logo')->store('brands', 'public');
            }

            $updated = $this->repository->update($id, $data);
            return $this->successResponse($updated, 'Brand updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $brand = $this->repository->find($id);

            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }

            $this->repository->delete($id);
            return $this->successResponse(null, 'Brand deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $this->repository->reorder($request->order);
            return $this->successResponse(null, 'Brands reordered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function types()
    {
        try {
            $types = $this->repository->getTypes();
            return $this->successResponse($types);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
