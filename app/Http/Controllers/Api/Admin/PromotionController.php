<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\PromotionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PromotionController extends BaseApiController
{
    protected $repository;

    public function __construct(PromotionRepository $repository)
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'promo_type' => 'required|in:percentage,fixed,bundle',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('promotions', 'public');
            }

            $promotion = $this->repository->create($data);
            return $this->createdResponse($promotion, 'Promotion created successfully');
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'promo_type' => 'sometimes|required|in:percentage,fixed,bundle',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'terms' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $promotion = $this->repository->find($id);
            $data = $request->all();

            if ($request->hasFile('image')) {
                if ($promotion->image) {
                    Storage::disk('public')->delete($promotion->image);
                }
                $data['image'] = $request->file('image')->store('promotions', 'public');
            }

            $updated = $this->repository->update($id, $data);
            return $this->successResponse($updated, 'Promotion updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $promotion = $this->repository->find($id);

            if ($promotion->image) {
                Storage::disk('public')->delete($promotion->image);
            }

            $this->repository->delete($id);
            return $this->successResponse(null, 'Promotion deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:promotions,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $this->repository->reorder($request->order);
            return $this->successResponse(null, 'Promotions reordered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
