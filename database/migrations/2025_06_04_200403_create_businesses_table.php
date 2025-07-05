<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();

            // علاقات
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('governorate_id')->constrained()->onDelete('cascade');


            // البيانات الأساسية
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // بيانات تاتي من استيراد Google maps
            $table->string('place_id')->unique()->comment('معرّف المكان من Google Places');
            $table->decimal('rating', 3, 2)->nullable()->comment('متوسط التقييم من Google');
            $table->unsignedInteger('reviews_count')->nullable()->comment('عدد التقييمات من Google');

            // حالة النشاط
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_active')->default(true);

            // صورة النشاط
            $table->text('image')->nullable();

            // معرض الصور
            $table->json('gallery')->nullable();

            // روابط التواصل الاجتماعي
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();

            // التواريخ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
