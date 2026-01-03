<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Public\LandingPageController;
use App\Http\Controllers\Api\Admin\HeroSectionController;
use App\Http\Controllers\Api\Admin\ServiceController;
use App\Http\Controllers\Api\Admin\BlogPostController;

// Public API Routes
Route::prefix('public')->group(function () {
    Route::get('/landing', [LandingPageController::class, 'index']);
    Route::get('/hero-sections', [LandingPageController::class, 'heroSections']);
    Route::get('/services', [LandingPageController::class, 'services']);
    Route::get('/testimonials', [LandingPageController::class, 'testimonials']);
    Route::get('/gallery', [LandingPageController::class, 'gallery']);
    Route::get('/blogs', [LandingPageController::class, 'blogs']);
    Route::get('/blogs/{slug}', [LandingPageController::class, 'blogDetail']);
    Route::get('/contact-info', [LandingPageController::class, 'contactInfo']);
});

// Admin API Routes (Protected with auth middleware)
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {

    // Hero Sections
    Route::apiResource('hero-sections', HeroSectionController::class);
    Route::post('hero-sections/reorder', [HeroSectionController::class, 'reorder']);

    // Services
    Route::apiResource('services', ServiceController::class);
    Route::post('services/reorder', [ServiceController::class, 'reorder']);

    // Blog Posts
    Route::apiResource('blog-posts', BlogPostController::class);

    // Testimonials
    Route::apiResource('testimonials', \App\Http\Controllers\Api\Admin\TestimonialController::class);
    Route::post('testimonials/reorder', [\App\Http\Controllers\Api\Admin\TestimonialController::class, 'reorder']);

    // Gallery
    Route::apiResource('galleries', \App\Http\Controllers\Api\Admin\GalleryController::class);
    Route::get('gallery/categories', [\App\Http\Controllers\Api\Admin\GalleryController::class, 'categories']);

    // Team Members
    Route::apiResource('team-members', \App\Http\Controllers\Api\Admin\TeamMemberController::class);
    Route::post('team-members/reorder', [\App\Http\Controllers\Api\Admin\TeamMemberController::class, 'reorder']);

    // FAQs
    Route::apiResource('faqs', \App\Http\Controllers\Api\Admin\FaqController::class);
    Route::post('faqs/reorder', [\App\Http\Controllers\Api\Admin\FaqController::class, 'reorder']);

    // Partners
    Route::apiResource('partners', \App\Http\Controllers\Api\Admin\PartnerController::class);
    Route::post('partners/reorder', [\App\Http\Controllers\Api\Admin\PartnerController::class, 'reorder']);

    // Features
    Route::apiResource('features', \App\Http\Controllers\Api\Admin\FeatureController::class);
    Route::post('features/reorder', [\App\Http\Controllers\Api\Admin\FeatureController::class, 'reorder']);

    // About Section
    Route::apiResource('about-sections', \App\Http\Controllers\Api\Admin\AboutSectionController::class);

    // Contact Info
    Route::get('contact-info', [\App\Http\Controllers\Api\Admin\ContactInfoController::class, 'show']);
    Route::put('contact-info', [\App\Http\Controllers\Api\Admin\ContactInfoController::class, 'update']);

    // Site Settings
    Route::get('site-settings', [\App\Http\Controllers\Api\Admin\SiteSettingController::class, 'index']);
    Route::put('site-settings', [\App\Http\Controllers\Api\Admin\SiteSettingController::class, 'update']);
    Route::get('site-settings/{key}', [\App\Http\Controllers\Api\Admin\SiteSettingController::class, 'show']);
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
        Route::get('me', [\App\Http\Controllers\Api\Auth\AuthController::class, 'me']);
    });
});
