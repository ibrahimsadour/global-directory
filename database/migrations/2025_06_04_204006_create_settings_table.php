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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();     // مثال: site_name, site_logo
            $table->text('value')->nullable();   // قيمة الإعداد
            $table->string('group')->nullable(); // لتقسيم الإعدادات (site, app, security...)
            $table->string('type')->nullable();  // text, image, email, boolean...
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
