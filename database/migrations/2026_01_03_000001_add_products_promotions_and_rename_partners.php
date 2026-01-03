<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Create Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->string('category'); // oli, parts, accessories, chemicals
            $table->string('brand')->nullable(); // Shell, Castrol, Mobil, etc
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // multiple images
            $table->decimal('price', 15, 2);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('unit')->default('pcs'); // liter, pcs, box, etc
            $table->json('specifications')->nullable(); // SAE, viscosity, etc
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Create Promotions Table
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('promo_type'); // percentage, fixed, bundle
            $table->decimal('discount_value', 15, 2)->nullable();
            $table->string('discount_percentage')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('terms')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Rename partners to brands
        Schema::rename('partners', 'brands');

        // Add description field to brands table
        Schema::table('brands', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('type')->default('oil')->after('description'); // oil, parts, tire, battery
        });
    }

    public function down(): void
    {
        // Remove description and type from brands
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['description', 'type']);
        });

        // Rename back to partners
        Schema::rename('brands', 'partners');

        Schema::dropIfExists('promotions');
        Schema::dropIfExists('products');
    }
};
