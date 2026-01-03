<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends BaseApiController
{
    protected $repository;

    public function __construct(TestimonialRepository $repository)
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
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'customer_company' => 'nullable|string|max:255',
            'customer_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $data = $request->all();

            if ($request->hasFile('customer_avatar')) {
                $data['customer_avatar'] = $request->file('customer_avatar')->store('testimonials', 'public');
            }

            $testimonial = $this->repository->create($data);
            return $this->createdResponse($testimonial, 'Testimonial created successfully');
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
            'customer_name' => 'sometimes|required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'customer_company' => 'nullable|string|max:255',
            'customer_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'content' => 'sometimes|required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $testimonial = $this->repository->find($id);
            $data = $request->all();

            if ($request->hasFile('customer_avatar')) {
                if ($testimonial->customer_avatar) {
                    Storage::disk('public')->delete($testimonial->customer_avatar);
                }
                $data['customer_avatar'] = $request->file('customer_avatar')->store('testimonials', 'public');
            }

            $updated = $this->repository->update($id, $data);
            return $this->successResponse($updated, 'Testimonial updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $testimonial = $this->repository->find($id);

            if ($testimonial->customer_avatar) {
                Storage::disk('public')->delete($testimonial->customer_avatar);
            }

            $this->repository->delete($id);
            return $this->successResponse(null, 'Testimonial deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:testimonials,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $this->repository->reorder($request->order);
            return $this->successResponse(null, 'Testimonials reordered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
