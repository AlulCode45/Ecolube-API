<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\HeroSectionService;
use App\Services\ServiceService;
use App\Services\BlogPostService;
use App\Repositories\TestimonialRepository;
use App\Repositories\GalleryRepository;
use App\Models\ContactInfo;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class LandingPageController extends BaseApiController
{
    protected $heroService;
    protected $serviceService;
    protected $blogService;
    protected $testimonialRepo;
    protected $galleryRepo;

    public function __construct(
        HeroSectionService $heroService,
        ServiceService $serviceService,
        BlogPostService $blogService,
        TestimonialRepository $testimonialRepo,
        GalleryRepository $galleryRepo
    ) {
        $this->heroService = $heroService;
        $this->serviceService = $serviceService;
        $this->blogService = $blogService;
        $this->testimonialRepo = $testimonialRepo;
        $this->galleryRepo = $galleryRepo;
    }

    public function index()
    {
        try {
            $data = [
                'hero_sections' => $this->heroService->getActive(),
                'services' => $this->serviceService->getActive(),
                'testimonials' => $this->testimonialRepo->getActive(),
                'gallery' => $this->galleryRepo->getActive()->take(6),
                'latest_posts' => $this->blogService->getPublished(3),
                'contact_info' => ContactInfo::first(),
                'site_settings' => $this->getSiteSettings(),
            ];

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function heroSections()
    {
        try {
            $data = $this->heroService->getActive();
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function services()
    {
        try {
            $data = $this->serviceService->getActive();
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function testimonials()
    {
        try {
            $data = $this->testimonialRepo->getActive();
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function gallery(Request $request)
    {
        try {
            $category = $request->get('category');

            $data = $category
                ? $this->galleryRepo->getByCategory($category)
                : $this->galleryRepo->getActive();

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function blogs(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 12);
            $category = $request->get('category');
            $search = $request->get('search');

            if ($search) {
                $data = $this->blogService->search($search, $perPage);
            } elseif ($category) {
                $data = $this->blogService->getByCategory($category, $perPage);
            } else {
                $data = $this->blogService->getPublished($perPage);
            }

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function blogDetail($slug)
    {
        try {
            $data = $this->blogService->findBySlug($slug);
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function contactInfo()
    {
        try {
            $data = ContactInfo::first();
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    protected function getSiteSettings()
    {
        $settings = SiteSetting::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }

        return $result;
    }
}
