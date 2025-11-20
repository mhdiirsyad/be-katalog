<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'store_name' => ['required', 'string', 'max:255'],
            'store_description' => ['nullable', 'string'],
            'pic_name' => ['required', 'string', 'max:255', 'unique:sellers,pic_name'],
            'pic_phone' => ['required', 'string', 'max:20'],
            'pic_email' => ['required', 'string', 'email', 'max:255', 'unique:sellers,pic_email'],
            'pic_street' => ['required', 'string', 'max:255'],
            'pic_RT' => ['required', 'string', 'max:10'],
            'pic_RW' => ['required', 'string', 'max:10'],
            'pic_village' => ['required', 'string', 'max:255'],
            'pic_city' => ['required', 'string', 'max:255'],
            'pic_province' => ['required', 'string', 'max:255'],
            'pic_ktp_number' => ['required', 'string', 'max:255', 'unique:sellers,pic_ktp_number'],
            'pic_photo_path' => ['required', 'string', 'max:255'],
            'pic_ktp_file_path' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
