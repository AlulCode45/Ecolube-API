<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends BaseApiController
{
    public function index()
    {
        try {
            $settings = SiteSetting::all();
            $grouped = $settings->groupBy('group');
            return $this->successResponse($grouped);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show($key)
    {
        try {
            $setting = SiteSetting::where('key', $key)->first();

            if (!$setting) {
                return $this->errorResponse('Setting not found', 404);
            }

            return $this->successResponse($setting);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'settings' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            foreach ($request->settings as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            $settings = SiteSetting::all();
            return $this->successResponse($settings, 'Settings updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
