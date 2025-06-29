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
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('source_url')->unique(); // مثل: /categories/retail-shops
            $table->string('target_url'); // مثل: /
            $table->boolean('active')->default(true); // لتفعيل أو إيقاف التوجيه
            $table->unsignedSmallInteger('status_code')->default(301); // كود التحويل: 301 أو 302
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
