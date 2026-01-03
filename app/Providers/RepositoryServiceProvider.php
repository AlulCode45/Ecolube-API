<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repositories
use App\Repositories\HeroSectionRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\TestimonialRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\BlogPostRepository;
use App\Repositories\AboutSectionRepository;
use App\Repositories\FeatureRepository;
use App\Repositories\TeamMemberRepository;
use App\Repositories\FaqRepository;
use App\Repositories\PartnerRepository;

// Models
use App\Models\HeroSection;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\BlogPost;
use App\Models\AboutSection;
use App\Models\Feature;
use App\Models\TeamMember;
use App\Models\Faq;
use App\Models\Partner;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Repositories
        $this->app->bind(HeroSectionRepository::class, function ($app) {
            return new HeroSectionRepository(new HeroSection());
        });

        $this->app->bind(ServiceRepository::class, function ($app) {
            return new ServiceRepository(new Service());
        });

        $this->app->bind(TestimonialRepository::class, function ($app) {
            return new TestimonialRepository(new Testimonial());
        });

        $this->app->bind(GalleryRepository::class, function ($app) {
            return new GalleryRepository(new Gallery());
        });

        $this->app->bind(BlogPostRepository::class, function ($app) {
            return new BlogPostRepository(new BlogPost());
        });

        $this->app->bind(AboutSectionRepository::class, function ($app) {
            return new AboutSectionRepository(new AboutSection());
        });

        $this->app->bind(FeatureRepository::class, function ($app) {
            return new FeatureRepository(new Feature());
        });

        $this->app->bind(TeamMemberRepository::class, function ($app) {
            return new TeamMemberRepository(new TeamMember());
        });

        $this->app->bind(FaqRepository::class, function ($app) {
            return new FaqRepository(new Faq());
        });

        $this->app->bind(PartnerRepository::class, function ($app) {
            return new PartnerRepository(new Partner());
        });
    }

    public function boot(): void
    {
        //
    }
}
