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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('address_id')->nullable()->constrained();
            $table->string('status')->nullable();
            $table->string('onboarding_status')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
        });

        Schema::create('user_password_reset_tokens', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable();
            $table->string('email')->primary();
            $table->string('token');
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->string('status')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
        });

        Schema::create('admin_password_reset_tokens', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable();
            $table->string('email')->primary();
            $table->string('token');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_password_reset_tokens');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('admin_password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
