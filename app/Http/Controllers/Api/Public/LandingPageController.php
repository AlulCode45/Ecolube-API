<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\HeroSectionService;
use App\Services\ServiceService;
use App\Services\BlogPostService;
use App\Repositories\TestimonialRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;
use App\Repositories\BrandRepository;
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
    protected $productRepo;
    protected $promotionRepo;
    protected $brandRepo;

    public function __construct(
        HeroSectionService $heroService,
        ServiceService $serviceService,
        BlogPostService $blogService,
        TestimonialRepository $testimonialRepo,
        GalleryRepository $galleryRepo,
        ProductRepository $productRepo,
        PromotionRepository $promotionRepo,
        BrandRepository $brandRepo
    ) {
        $this->heroService = $heroService;
        $this->serviceService = $serviceService;
        $this->blogService = $blogService;
        $this->testimonialRepo = $testimonialRepo;
        $this->galleryRepo = $galleryRepo;
        $this->productRepo = $productRepo;
        $this->promotionRepo = $promotionRepo;
        $this->brandRepo = $brandRepo;
    }

    public function index()
    {
        try {
            $data = [
                'hero_sections' => $this->heroService->getActive(),
                'services' => $this->serviceService->getActive(),
                'featured_products' => $this->productRepo->getFeatured(),
                'active_promotions' => $this->promotionRepo->getActive(),
                'brands' => $this->brandRepo->getActive(),
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

    public function products(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 12);
            $category = $request->get('category');
            $search = $request->get('search');
            $featured = $request->get('featured');

            if ($featured) {
                $data = $this->productRepo->getFeatured();
            } elseif ($search) {
                $data = $this->productRepo->search($search);
            } elseif ($category) {
                $data = $this->productRepo->getByCategory($category);
            } else {
                $data = $this->productRepo->getActive();
            }

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function productDetail($id)
    {
        try {
            $product = $this->productRepo->find($id);
            return $this->successResponse($product);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function promotions()
    {
        try {
            $data = $this->promotionRepo->getActive();
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function brands(Request $request)
    {
        try {
            $type = $request->get('type');

            $data = $type
                ? $this->brandRepo->getByType($type)
                : $this->brandRepo->getActive();

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
