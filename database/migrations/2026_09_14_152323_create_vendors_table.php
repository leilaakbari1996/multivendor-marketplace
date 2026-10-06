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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('store_name');
            $table->string('url')->unique();
            $table->text('bio')->nullable();
            $table->string('national_code', 10)->nullable()->unique();
            $table->decimal('commission_rate', 5, 2)->default(10.00); // یعنی 10.00%
            $table->string('status')->default(\App\Enums\VendorStatus::PENDING->value);
            $table->text('rejected_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
