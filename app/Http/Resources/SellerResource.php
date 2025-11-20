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
            'store_name' => $this->store_name,
            'store_description' => $this->store_description,
            'pic_name' => $this->pic_name,
            'pic_phone' => $this->pic_phone,
            'pic_email' => $this->pic_email,
            'pic_street' => $this->pic_street,
            'pic_RT' => $this->pic_RT,
            'pic_RW' => $this->pic_RW,
            'pic_village' => $this->pic_village,
            'pic_city' => $this->pic_city,
            'pic_province' => $this->pic_province,
            'pic_ktp_number' => $this->pic_ktp_number,
            'pic_photo_path' => $this->pic_photo_path,
            'pic_ktp_file_path' => $this->pic_ktp_file_path,
            'status' => $this->status,
        ];
    }
}
