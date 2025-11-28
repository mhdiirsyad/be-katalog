<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'store_name' => $this->nama_toko,
            'store_description' => $this->deskripsi_singkat,
            'pic_name' => $this->nama_pic,
            'pic_phone' => $this->no_hp_pic,
            'pic_email' => $this->email_pic,
            'pic_street' => $this->alamat_pic,
            'pic_RT' => $this->rt,
            'pic_RW' => $this->rw,
            'nama_kelurahan' => $this->village->name,
            'nama_kecamatan' => $this->village->getDistrictNameAttribute(),
            'kabupaten_kota' => $this->village->getCityNameAttribute(),
            'propinsi' => $this->village->getProvinceNameAttribute(),
            'pic_ktp_number' => $this->no_ktp_pic,
            'pic_photo_path' => $this->foto_pic,
            'pic_ktp_file_path' => $this->file_ktp_pic,
            'status' => $this->status,
        ];
    }
}
