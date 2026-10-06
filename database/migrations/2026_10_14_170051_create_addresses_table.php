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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // عنوان آدرس
            $table->string('title', 30);

            // اطلاعات گیرنده
            $table->string('recipient_name', 60);
            $table->string('recipient_mobile', 11);

            // موقعیت جغرافیایی
            // جدول‌های iran_* با increments (unsigned INT) ساخته شده‌اند،
            // پس نوع ستون‌ها باید دقیقاً unsignedInteger باشد.
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->unsignedInteger('sector_id');
            $table->unsignedInteger('city_id');

            $table->foreign('province_id')
                ->references('id')->on('iran_provinces')
                ->restrictOnDelete();

            $table->foreign('county_id')
                ->references('id')->on('iran_counties')
                ->restrictOnDelete();

            $table->foreign('sector_id')
                ->references('id')->on('iran_sectors')
                ->restrictOnDelete();

            $table->foreign('city_id')
                ->references('id')->on('iran_cities')
                ->restrictOnDelete();

            // جزئیات آدرس
            $table->text('address');

            $table->string('postal_code', 10);

            $table->unsignedSmallInteger('plaque')->nullable();

            $table->string('unit', 10)->nullable();

            // آدرس پیش‌فرض
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
