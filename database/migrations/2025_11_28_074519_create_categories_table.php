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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon'); 
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (Penjual)
            // 'cascade' artinya jika user dihapus, produknya ikut terhapus otomatis
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('nama');
            $table->decimal('harga', 12, 2);
            $table->integer('berat')->default(0);
            $table->text('deskripsi')->nullable();
            
            $table->float('rating')->default(0);
            $table->integer('sold')->default(0);
            
            $table->string('image')->nullable();
            
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PENTING: Hapus products dulu karena dia punya foreign key ke categories
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};