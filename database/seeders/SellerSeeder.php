<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seller AKTIF
        Seller::create([
            'nama_toko' => 'Toko Gadget Sejahtera',
            'deskripsi_singkat' => 'Pusat gadget.',
            'nama_pic' => 'Budi Santoso',
            'no_hp_pic' => '081234567890',
            'email_pic' => 'seller@example.com',
            'password' => Hash::make('password'),
            'alamat_pic' => 'Jl. Kebon Jeruk No. 12',
            'rt' => '001', 'rw' => '005',
            'nama_kelurahan' => 'Kebon Jeruk', 'nama_kecamatan' => 'Kebon Jeruk',
            'kabupaten_kota' => 'Jakarta Barat', 'propinsi' => 'DKI Jakarta',
            
            'no_ktp_pic' => '3171234567890001',
            // PERBAIKAN DISINI: Isi dengan string dummy, jangan null
            'foto_pic' => 'dummy_photo.jpg', 
            'file_ktp_pic' => 'dummy_ktp.pdf',
            
            'status' => 'ACTIVE',
        ]);

        // 2. Seller PENDING
        Seller::create([
            'nama_toko' => 'Warung Sembako Berkah',
            'deskripsi_singkat' => 'Baru daftar.',
            'nama_pic' => 'Siti Aminah',
            'no_hp_pic' => '089876543210',
            'email_pic' => 'pending@example.com',
            'password' => Hash::make('password'),
            'alamat_pic' => 'Jl. Ahmad Yani No. 88',
            'rt' => '002', 'rw' => '003',
            'nama_kelurahan' => 'Cempaka Putih', 'nama_kecamatan' => 'Cempaka Putih',
            'kabupaten_kota' => 'Jakarta Pusat', 'propinsi' => 'DKI Jakarta',
            
            'no_ktp_pic' => '3171234567890002',
            // PERBAIKAN DISINI
            'foto_pic' => 'dummy_photo.jpg',
            'file_ktp_pic' => 'dummy_ktp.pdf',
            
            'status' => 'PENDING',
        ]);

        // 3. Seller REJECTED
        Seller::create([
            'nama_toko' => 'Toko Barang Aneh',
            'deskripsi_singkat' => 'Melanggar aturan.',
            'nama_pic' => 'Joko Susilo',
            'no_hp_pic' => '085678901234',
            'email_pic' => 'reject@example.com',
            'password' => Hash::make('password'),
            'alamat_pic' => 'Jl. Buntu No. 0',
            'rt' => '000', 'rw' => '000',
            'nama_kelurahan' => 'Unknown', 'nama_kecamatan' => 'Unknown',
            'kabupaten_kota' => 'Jakarta Selatan', 'propinsi' => 'DKI Jakarta',
            
            'no_ktp_pic' => '3171234567890003',
            // PERBAIKAN DISINI
            'foto_pic' => 'dummy_photo.jpg',
            'file_ktp_pic' => 'dummy_ktp.pdf',
            
            'status' => 'REJECTED',
        ]);
    }
}