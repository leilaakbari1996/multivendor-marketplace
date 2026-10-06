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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            $table->string('type')->default(\App\Enums\CouponType::PERCENTAGE->value);

            // اگر percentage باشد مثلاً 10.00 یعنی 10%
            // اگر fixed باشد مثلاً 100000 یعنی 100 هزار تومان
            $table->decimal('value', 12, 2);

            $table->unsignedBigInteger('min_order_amount')->nullable();

            $table->unsignedBigInteger('max_discount_amount')->nullable();

            $table->unsignedInteger('usage_limit')->nullable();

            $table->unsignedInteger('used_count')->default(0);

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
