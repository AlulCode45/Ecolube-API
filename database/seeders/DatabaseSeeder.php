<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HeroSection;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Ecolube',
            'email' => 'admin@ecolube.id',
            'password' => bcrypt('password123'),
        ]);

        // Create Hero Sections
        HeroSection::create([
            'title' => 'Professional Automotive Care',
            'subtitle' => 'Quality service for your vehicle with expert technicians',
            'cta_primary_text' => 'Book Service',
            'cta_primary_link' => '/booking',
            'cta_secondary_text' => 'Learn More',
            'cta_secondary_link' => '/about',
            'order' => 1,
            'is_active' => true,
        ]);

        // Create Services
        $services = [
            [
                'name' => 'Oil Change Service',
                'description' => 'Complete oil change with premium quality oil and filter replacement',
                'icon' => 'wrench',
                'price' => 50.00,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Brake Inspection',
                'description' => 'Comprehensive brake system check and maintenance',
                'icon' => 'disc',
                'price' => 75.00,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Tire Service',
                'description' => 'Tire rotation, balancing, and pressure check',
                'icon' => 'circle',
                'price' => 40.00,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Testimonials
        $testimonials = [
            [
                'customer_name' => 'John Doe',
                'customer_position' => 'Business Owner',
                'customer_company' => 'ABC Corp',
                'content' => 'Excellent service! My car runs smoother than ever. The team is professional and friendly.',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Jane Smith',
                'customer_position' => 'Marketing Manager',
                'content' => 'Fast and reliable service. I always trust them with my vehicle maintenance.',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // Create Contact Info
        ContactInfo::create([
            'phone' => '+62 21 1234 5678',
            'email' => 'info@ecolube.id',
            'address' => 'Jl. Contoh No. 123, Jakarta, Indonesia',
            'whatsapp' => '+62 812 3456 7890',
            'social_media' => [
                'facebook' => 'https://facebook.com/ecolube',
                'instagram' => 'https://instagram.com/ecolube',
                'twitter' => 'https://twitter.com/ecolube',
            ],
            'business_hours' => [
                'monday' => '08:00 - 17:00',
                'tuesday' => '08:00 - 17:00',
                'wednesday' => '08:00 - 17:00',
                'thursday' => '08:00 - 17:00',
                'friday' => '08:00 - 17:00',
                'saturday' => '08:00 - 14:00',
                'sunday' => 'Closed',
            ],
        ]);

        // Create Site Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Ecolube.id', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Professional Automotive Care Service', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => '', 'type' => 'image', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => '', 'type' => 'image', 'group' => 'general'],
            ['key' => 'footer_text', 'value' => '© 2026 Ecolube.id. All rights reserved.', 'type' => 'text', 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
