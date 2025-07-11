<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('business_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();

            $table->ipAddress('ip')->index();

            $table->timestamp('viewed_at')->default(now());

            // اختياري: لو حاب تمنع التكرار التام (ليستمر فعالًا استخدم الكود بدل unique)
            // $table->unique(['business_id', 'ip'], 'unique_business_ip');

            $table->timestamps(); // اختياري
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            //
        });
    }
};
