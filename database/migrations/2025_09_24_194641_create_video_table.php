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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(1);
            $table->integer('position')->default(0);
            $table->boolean('featured')->default(0);
            $table->string('name');
            $table->text('share_link');
            $table->string('thumbnail');
            $table->integer('view_count')->default(0);
            $table->integer('duration')->nullable();
            $table->longText('description')->nullable();
            $table->double('price')->nullable();
        });

        Schema::create('video_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_user');
        Schema::dropIfExists('videos');
    }
};
