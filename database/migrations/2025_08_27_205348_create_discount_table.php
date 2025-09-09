<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('active')->default(1);
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('type');
            $table->integer('weeks')->nullable();
            $table->integer('value')->nullable();
            $table->integer('percent')->nullable();
        });

        Schema::create('discount_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('discount_id');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_user');
        Schema::dropIfExists('discounts');
    }
};
