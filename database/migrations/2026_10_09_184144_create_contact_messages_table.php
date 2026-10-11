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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->string('subject', 50); // value انگلیسی Enum
            $table->text('message');
            $table->string('status', 20)->default(\App\Enums\ContactMessageStatus::NEW->value);
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
