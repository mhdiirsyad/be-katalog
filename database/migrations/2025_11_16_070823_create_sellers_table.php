<?php

use App\SellerStatus; // Pastikan import ini ada
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // 1. Nama toko
            $table->string('nama_toko')->unique();
            // 2. Deskripsi singkat
            $table->string('deskripsi_singkat')->nullable();
            // 3. Nama PIC
            $table->string('nama_pic');
            // 4. No Handphone PIC
            $table->string('no_hp_pic')->unique();
            // 5. email PIC
            $table->string('email_pic')->unique();
            // 6. Alamat (nama jalan) PIC
            $table->string('alamat_pic');
            // 7. RT
            $table->string('rt');
            // 8. RW
            $table->string('rw');
            // 9. Nama kelurahan
            $table->string('nama_kelurahan');
            // Tambahan: Kecamatan (Request kamu)
            $table->string('nama_kecamatan'); 
            // 10. Kabupaten/Kota
            $table->string('kabupaten_kota');
            // 11. Propinsi (Sesuai tulisan di gambar: Propinsi)
            $table->string('propinsi');
            // 12. No. KTP PIC
            $table->string('no_ktp_pic')->unique();
            
            // 13. Foto PIC (Path file)
            $table->string('foto_pic');
            // 14. File upload KTP PIC (Path file)
            $table->string('file_ktp_pic');

            // Status & System (Tetap Inggris karena bawaan Laravel/Enum)
            $table->enum('status', array_map(fn($case) => $case->name, \App\SellerStatus::cases()))->default(\App\SellerStatus::PENDING->name);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};