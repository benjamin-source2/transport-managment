<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('client');
            $table->string('profile_photo_path')->nullable();
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('base_price', 10, 2)->default(0);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('confirmed');
        });

        Schema::table('buses', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'profile_photo_path']);
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('base_price');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['price', 'user_id', 'phone', 'email', 'status']);
        });

        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'description']);
        });
    }
};
