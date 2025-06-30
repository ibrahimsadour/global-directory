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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');      // المراجع
            $table->foreignId('business_id')->constrained()->onDelete('cascade');  // النشاط
            $table->tinyInteger('rating');      // من 1 إلى 5 مثلاً
            $table->text('message')->nullable(); // تعليق المستخدم
            $table->boolean('is_approved')->default(false); // موافقة المشرف
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
