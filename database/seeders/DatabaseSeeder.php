<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\TeamMember;
use App\Models\Faq;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\BlogPost;
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

        HeroSection::create([
            'title' => 'Expert Maintenance & Repair',
            'subtitle' => 'Keep your vehicle running smoothly with our certified mechanics',
            'cta_primary_text' => 'Get Quote',
            'cta_primary_link' => '/quote',
            'cta_secondary_text' => 'Contact Us',
            'cta_secondary_link' => '/contact',
            'order' => 2,
            'is_active' => true,
        ]);

        // Create About Sections
        AboutSection::create([
            'title' => 'About Ecolube.id',
            'content' => 'We are a professional automotive care service provider with over 10 years of experience. Our team of certified mechanics is dedicated to providing the best service for your vehicle. We use only quality parts and materials to ensure your satisfaction.',
            'is_active' => true,
        ]);

        AboutSection::create([
            'title' => 'Our Mission',
            'content' => 'To provide reliable, affordable, and professional automotive care services to all vehicle owners. We believe in building long-term relationships with our customers through trust and quality service.',
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

        // Create Features
        $features = [
            [
                'title' => 'Certified Mechanics',
                'description' => 'Our team consists of certified and experienced mechanics who know your vehicle inside out',
                'icon' => 'award',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Quality Parts',
                'description' => 'We use only genuine and high-quality parts for all repairs and maintenance',
                'icon' => 'shield-check',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Warranty Service',
                'description' => 'All our services come with warranty coverage for your peace of mind',
                'icon' => 'check-circle',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Fast Service',
                'description' => 'Quick turnaround time without compromising quality',
                'icon' => 'clock',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
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

        // Create Gallery Items
        $galleryItems = [
            [
                'title' => 'Modern Service Center',
                'description' => 'Our state-of-the-art service facility',
                'image' => 'gallery/facility-1.jpg',
                'category' => 'Facility',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Professional Equipment',
                'description' => 'Latest diagnostic and repair tools',
                'image' => 'gallery/equipment-1.jpg',
                'category' => 'Equipment',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Team at Work',
                'description' => 'Our mechanics providing quality service',
                'image' => 'gallery/team-1.jpg',
                'category' => 'Team',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Customer Lounge',
                'description' => 'Comfortable waiting area for our customers',
                'image' => 'gallery/facility-2.jpg',
                'category' => 'Facility',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($galleryItems as $item) {
            Gallery::create($item);
        }

        // Create Team Members
        $teamMembers = [
            [
                'name' => 'Ahmad Wijaya',
                'position' => 'Chief Mechanic',
                'bio' => 'With over 15 years of experience in automotive care, Ahmad leads our technical team with expertise and dedication.',
                'email' => 'ahmad@ecolube.id',
                'phone' => '+62 812 3456 7891',
                'social_media' => [
                    'linkedin' => 'https://linkedin.com/in/ahmadwijaya',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'position' => 'Senior Technician',
                'bio' => 'Specialized in engine diagnostics and electrical systems with 10 years of hands-on experience.',
                'email' => 'budi@ecolube.id',
                'phone' => '+62 812 3456 7892',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Lestari',
                'position' => 'Customer Service Manager',
                'bio' => 'Ensuring every customer receives the best experience and support throughout their service journey.',
                'email' => 'dewi@ecolube.id',
                'phone' => '+62 812 3456 7893',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }

        // Create FAQs
        $faqs = [
            [
                'question' => 'How often should I change my oil?',
                'answer' => 'Generally, we recommend oil changes every 5,000 to 7,500 kilometers or every 6 months, whichever comes first. However, this can vary depending on your vehicle type and driving conditions.',
                'category' => 'Maintenance',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Do you provide warranty for your services?',
                'answer' => 'Yes, all our services come with a comprehensive warranty. The warranty period varies depending on the type of service, typically ranging from 30 days to 6 months.',
                'category' => 'General',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Can I wait while my car is being serviced?',
                'answer' => 'Absolutely! We have a comfortable customer lounge with complimentary Wi-Fi, refreshments, and entertainment where you can wait during your service.',
                'category' => 'General',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Do I need to make an appointment?',
                'answer' => 'While walk-ins are welcome, we highly recommend making an appointment to ensure prompt service and minimal waiting time. You can book online or call us directly.',
                'category' => 'Booking',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept cash, debit cards, credit cards, and various mobile payment methods including e-wallets. Contact us for the complete list of accepted payment methods.',
                'category' => 'Payment',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // Create Brands
        $brands = [
            [
                'name' => 'Shell Helix',
                'description' => 'Premium motor oil brand with advanced cleaning technology',
                'type' => 'oil',
                'logo' => 'brands/shell-logo.png',
                'website' => 'https://www.shell.com',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Castrol',
                'description' => 'High-performance lubricants trusted by professionals worldwide',
                'type' => 'oil',
                'logo' => 'brands/castrol-logo.png',
                'website' => 'https://www.castrol.com',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Mobil 1',
                'description' => 'World-leading synthetic motor oil technology',
                'type' => 'oil',
                'logo' => 'brands/mobil1-logo.png',
                'website' => 'https://www.mobil1.com',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Bosch',
                'description' => 'Reliable automotive parts and accessories',
                'type' => 'parts',
                'logo' => 'brands/bosch-logo.png',
                'website' => 'https://www.bosch.com',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Michelin',
                'description' => 'World-renowned tire manufacturer',
                'type' => 'tire',
                'logo' => 'brands/michelin-logo.png',
                'website' => 'https://www.michelin.com',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'GS Astra',
                'description' => 'Quality batteries for Indonesian vehicles',
                'type' => 'battery',
                'logo' => 'brands/gs-astra-logo.png',
                'website' => 'https://www.gs-astra.com',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        // Create Products
        $products = [
            // Shell Products
            [
                'name' => 'Shell Helix HX8 5W-40',
                'sku' => 'SHL-HX8-5W40-4L',
                'description' => 'Fully synthetic motor oil for high-performance engines. Provides excellent protection and cleaning power.',
                'category' => 'oli',
                'brand' => 'Shell Helix',
                'image' => 'products/shell-hx8.jpg',
                'price' => 350000,
                'discount_price' => 320000,
                'stock' => 50,
                'unit' => '4L',
                'specifications' => [
                    'viscosity' => '5W-40',
                    'type' => 'Fully Synthetic',
                    'api' => 'SN/CF',
                    'acea' => 'A3/B3, A3/B4',
                ],
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Shell Helix Ultra 0W-20',
                'sku' => 'SHL-ULT-0W20-4L',
                'description' => 'Premium fully synthetic oil for modern engines with superior fuel economy.',
                'category' => 'oli',
                'brand' => 'Shell Helix',
                'image' => 'products/shell-ultra.jpg',
                'price' => 450000,
                'stock' => 30,
                'unit' => '4L',
                'specifications' => [
                    'viscosity' => '0W-20',
                    'type' => 'Fully Synthetic',
                    'api' => 'SP',
                    'ilsac' => 'GF-6A',
                ],
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            // Castrol Products
            [
                'name' => 'Castrol EDGE 5W-30',
                'sku' => 'CST-EDGE-5W30-4L',
                'description' => 'Advanced full synthetic oil with Fluid TITANIUM technology for maximum engine performance.',
                'category' => 'oli',
                'brand' => 'Castrol',
                'image' => 'products/castrol-edge.jpg',
                'price' => 380000,
                'discount_price' => 350000,
                'stock' => 45,
                'unit' => '4L',
                'specifications' => [
                    'viscosity' => '5W-30',
                    'type' => 'Fully Synthetic',
                    'api' => 'SN Plus',
                    'acea' => 'C3',
                ],
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Castrol GTX 10W-40',
                'sku' => 'CST-GTX-10W40-4L',
                'description' => 'Semi-synthetic motor oil for everyday driving protection.',
                'category' => 'oli',
                'brand' => 'Castrol',
                'image' => 'products/castrol-gtx.jpg',
                'price' => 250000,
                'stock' => 60,
                'unit' => '4L',
                'specifications' => [
                    'viscosity' => '10W-40',
                    'type' => 'Semi Synthetic',
                    'api' => 'SN',
                ],
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            // Mobil Products
            [
                'name' => 'Mobil 1 ESP Formula 5W-30',
                'sku' => 'MOB-ESP-5W30-4L',
                'description' => 'Premium synthetic oil for modern engines with emission control systems.',
                'category' => 'oli',
                'brand' => 'Mobil 1',
                'image' => 'products/mobil1-esp.jpg',
                'price' => 420000,
                'stock' => 35,
                'unit' => '4L',
                'specifications' => [
                    'viscosity' => '5W-30',
                    'type' => 'Fully Synthetic',
                    'api' => 'SN',
                    'acea' => 'C2, C3',
                ],
                'is_featured' => true,
                'is_active' => true,
                'order' => 5,
            ],
            // Bosch Parts
            [
                'name' => 'Bosch Oil Filter',
                'sku' => 'BSH-FLT-OF-001',
                'description' => 'High-quality oil filter for superior engine protection and performance.',
                'category' => 'parts',
                'brand' => 'Bosch',
                'image' => 'products/bosch-oil-filter.jpg',
                'price' => 75000,
                'stock' => 100,
                'unit' => 'pcs',
                'specifications' => [
                    'type' => 'Oil Filter',
                    'compatibility' => 'Universal',
                ],
                'is_featured' => false,
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Bosch Spark Plug Platinum',
                'sku' => 'BSH-SPK-PLT-001',
                'description' => 'Long-life platinum spark plugs for reliable ignition.',
                'category' => 'parts',
                'brand' => 'Bosch',
                'image' => 'products/bosch-spark-plug.jpg',
                'price' => 120000,
                'stock' => 80,
                'unit' => 'set/4pcs',
                'specifications' => [
                    'type' => 'Spark Plug',
                    'material' => 'Platinum',
                ],
                'is_featured' => false,
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Bosch Brake Pad Set',
                'sku' => 'BSH-BRK-PAD-001',
                'description' => 'Premium brake pads for safe and reliable braking performance.',
                'category' => 'parts',
                'brand' => 'Bosch',
                'image' => 'products/bosch-brake-pad.jpg',
                'price' => 450000,
                'stock' => 40,
                'unit' => 'set',
                'specifications' => [
                    'type' => 'Brake Pad',
                    'position' => 'Front',
                ],
                'is_featured' => false,
                'is_active' => true,
                'order' => 8,
            ],
            // Accessories
            [
                'name' => 'Car Shampoo Premium',
                'sku' => 'ACC-SHP-PRE-001',
                'description' => 'pH-balanced car shampoo for safe and effective cleaning.',
                'category' => 'chemicals',
                'brand' => null,
                'image' => 'products/car-shampoo.jpg',
                'price' => 85000,
                'stock' => 70,
                'unit' => '1L',
                'is_featured' => false,
                'is_active' => true,
                'order' => 9,
            ],
            [
                'name' => 'Engine Cleaner Foam',
                'sku' => 'ACC-ENG-CLN-001',
                'description' => 'Professional-grade engine bay cleaner and degreaser.',
                'category' => 'chemicals',
                'brand' => null,
                'image' => 'products/engine-cleaner.jpg',
                'price' => 95000,
                'stock' => 50,
                'unit' => '500ml',
                'is_featured' => false,
                'is_active' => true,
                'order' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create Promotions
        $promotions = [
            [
                'title' => 'New Year Oil Change Special',
                'description' => 'Get 10% OFF on all synthetic oil changes! Limited time offer for the new year. Includes free oil filter replacement.',
                'image' => 'promotions/new-year-promo.jpg',
                'promo_type' => 'percentage',
                'discount_percentage' => '10%',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'terms' => 'Valid for synthetic oil products only. Cannot be combined with other offers. Booking required.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Complete Service Package',
                'description' => 'Save Rp 150,000 on our complete service package! Includes oil change, brake check, tire rotation, and full inspection.',
                'image' => 'promotions/complete-service.jpg',
                'promo_type' => 'fixed',
                'discount_value' => 150000,
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'terms' => 'Minimum service value Rp 500,000. Valid for all vehicle types. Appointment required.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Buy 2 Get 1 Oil Filter',
                'description' => 'Purchase any 2 premium oil products and get 1 Bosch oil filter FREE! Perfect for regular maintenance.',
                'image' => 'promotions/buy-2-get-1.jpg',
                'promo_type' => 'bundle',
                'start_date' => now(),
                'end_date' => now()->addDays(45),
                'terms' => 'Free filter applies to standard Bosch oil filter only. While stocks last.',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }

        // Create Blog Posts
        $adminUser = User::first();

        $blogPosts = [
            [
                'title' => '5 Signs Your Car Needs an Oil Change',
                'slug' => '5-signs-your-car-needs-an-oil-change',
                'excerpt' => 'Learn to identify when your vehicle is due for an oil change to maintain optimal performance.',
                'content' => "Regular oil changes are crucial for your vehicle's health. Here are 5 signs to watch for:\n\n1. **Dark, Dirty Oil** - Clean oil is amber colored and translucent. If your oil is dark and murky, it's time for a change.\n\n2. **Engine Noise** - Oil lubricates your engine. If you hear knocking or rumbling, low oil levels might be the cause.\n\n3. **Oil Change Light** - Modern cars have sensors that detect when oil needs changing. Don't ignore this warning.\n\n4. **Exhaust Smoke** - Blue or gray smoke could indicate an oil leak or that your oil is burning.\n\n5. **Oil Smell Inside Car** - If you smell oil inside your car, you may have an oil leak.\n\nDon't wait for these signs! Follow your manufacturer's recommended oil change schedule.",
                'author_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'The Importance of Regular Vehicle Maintenance',
                'slug' => 'importance-of-regular-vehicle-maintenance',
                'excerpt' => 'Regular maintenance can save you money and extend your vehicle\'s lifespan significantly.',
                'content' => "Regular vehicle maintenance is not just about keeping your car running—it's an investment in safety, reliability, and longevity.\n\n**Benefits of Regular Maintenance:**\n\n1. **Safety** - Regular inspections ensure your brakes, tires, and other critical components are working properly.\n\n2. **Fuel Efficiency** - A well-maintained car runs more efficiently, saving you money on fuel.\n\n3. **Longer Lifespan** - Preventive maintenance helps avoid major repairs and extends your vehicle's life.\n\n4. **Better Resale Value** - A complete maintenance history increases your car's resale value.\n\n5. **Peace of Mind** - Knowing your car is in good condition gives you confidence on every journey.\n\n**Recommended Maintenance Schedule:**\n- Oil changes every 5,000-7,500 km\n- Tire rotation every 10,000 km\n- Brake inspection every 20,000 km\n- Major service every 40,000 km\n\nContact us to set up your regular maintenance schedule today!",
                'author_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Winter Car Care Tips',
                'slug' => 'winter-car-care-tips',
                'excerpt' => 'Prepare your vehicle for cold weather with these essential winter car care tips.',
                'content' => "While Indonesia doesn't have severe winters, proper car care is still essential during the rainy season.\n\n**Rainy Season Car Care Tips:**\n\n1. **Check Your Tires** - Ensure adequate tread depth for better traction on wet roads.\n\n2. **Test Your Wipers** - Replace worn wiper blades for clear visibility.\n\n3. **Inspect Lights** - All lights should work properly for safe driving in low visibility.\n\n4. **Check Battery** - Cold and damp conditions can affect battery performance.\n\n5. **Brake System** - Ensure your brakes are responsive, especially on wet roads.\n\n6. **Undercarriage Protection** - Prevent rust from constant water exposure.\n\n**Additional Tips:**\n- Keep an emergency kit in your car\n- Check coolant levels\n- Ensure proper ventilation to prevent fogging\n\nSchedule a pre-season checkup with us to ensure your car is ready!",
                'author_id' => $adminUser->id,
                'status' => 'draft',
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::create($post);
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
