<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Kiri: Key yang diterima Frontend
        // Kanan: Nama kolom di Database (Model Seller)
        return [
            'id' => $this->id,
            'store_name' => $this->nama_toko, 
            'store_description' => $this->deskripsi_singkat,
            'pic_name' => $this->nama_pic,
            'pic_phone' => $this->no_hp_pic,
            'pic_email' => $this->email_pic,
            
            // Alamat
            'pic_street' => $this->alamat_pic,
            'pic_rt' => $this->rt,
            'pic_rw' => $this->rw,
            'pic_village' => $this->nama_kelurahan,  // Kelurahan
            'pic_district' => $this->nama_kecamatan, // Kecamatan (Baru ditambahkan)
            'pic_city' => $this->kabupaten_kota,     // Kota/Kab
            'pic_province' => $this->propinsi,
            
            // Dokumen
            'pic_ktp_number' => $this->no_ktp_pic,
            // Helper 'url' agar frontend dapat full path gambar
            'pic_photo_url' => $this->foto_pic ? url('storage/' . $this->foto_pic) : null,
            'pic_ktp_url' => $this->file_ktp_pic ? url('storage/' . $this->file_ktp_pic) : null,
            
            'status' => $this->status,
        ];
    }
}