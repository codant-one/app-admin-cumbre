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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->boolean('full_profile')->default(false);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('lang')->default('es');
            $table->longText('token_2fa')->nullable();
            $table->longText('fcm_token')->nullable();
            $table->longText('device_type')->nullable();
            $table->timestamp('online')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();         
            
            $table->timestamps();
            $table->softDeletes();
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
