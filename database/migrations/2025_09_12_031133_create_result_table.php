<?php

declare(strict_types=1);

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
        Schema::create('result_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->foreignId('state_id')->constrained();
        });

        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('result_category_id')->constrained();
            $table->string('section')->nullable();
            $table->string('division')->nullable();
            $table->string('item')->nullable();
            $table->string('position')->nullable();
            $table->string('name')->nullable();
            $table->integer('points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
        Schema::dropIfExists('result_categories');
    }
};
