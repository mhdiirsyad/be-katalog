<?php

use App\SellerStatus;
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
        Schema::create('sellers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('store_name')->unique();
            $table->string('store_description')->nullable();
            $table->string('pic_name');
            $table->string('pic_phone')->unique();
            $table->string('pic_email')->unique();
            $table->string('pic_street');
            $table->string('pic_RT');
            $table->string('pic_RW');
            $table->string('pic_village');
            $table->string('pic_city');
            $table->string('pic_province');
            $table->string('pic_ktp_number')->unique();
            $table->string('pic_photo_path');
            $table->string('pic_ktp_file_path');
            $table->enum('status', array_map(fn($case) => $case->name, SellerStatus::cases()))->default(SellerStatus::PENDING->name);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
