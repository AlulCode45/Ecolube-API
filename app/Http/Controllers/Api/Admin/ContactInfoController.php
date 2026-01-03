<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactInfoController extends BaseApiController
{
    public function show()
    {
        try {
            $data = ContactInfo::first();
            if (!$data) {
                $data = ContactInfo::create([]);
            }
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:255',
            'social_media' => 'nullable|array',
            'business_hours' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $contactInfo = ContactInfo::first();

            if (!$contactInfo) {
                $contactInfo = ContactInfo::create($request->all());
            } else {
                $contactInfo->update($request->all());
            }

            return $this->successResponse($contactInfo, 'Contact info updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
