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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // بيانات أساسية
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // دور المستخدم
            $table->enum('role', ['admin', 'user'])->default('user');

            // معلومات إضافية
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable(); // يمكن تسميته profile_photo_path إذا كنت تستخدم التخزين
            $table->text('bio')->nullable();

            // حسابات الشبكات الاجتماعية
            $table->string('google_id')->nullable()->unique();
            $table->string('facebook_id')->nullable()->unique();
            $table->string('linkedin_id')->nullable()->unique();
            $table->string('twitter_id')->nullable()->unique();

            // مصدر التسجيل (google, facebook, manual)
            $table->string('provider')->nullable();

            // حالة التحقق والحالة العامة
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_trusted')->default(false);
            $table->boolean('status')->default(true);

            // تحليلات وأمان
            $table->timestamp('last_login_at')->nullable();
            $table->ipAddress('signup_ip')->nullable();

            // Laravel default
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
