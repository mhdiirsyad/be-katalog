<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 1. Informasi Toko
            'nama_toko' => 'required|string|max:255|unique:sellers,nama_toko',
            'deskripsi_singkat' => 'nullable|string|max:255', // Nullable (opsional) sesuai migrasi
            
            // 2. Informasi PIC (Personal)
            'nama_pic' => 'required|string|max:255',
            'no_hp_pic' => 'required|string|max:20|unique:sellers,no_hp_pic',
            'email_pic' => 'required|email|max:255|unique:sellers,email_pic',
            
            // 3. Alamat PIC
            'alamat_pic' => 'required|string|max:255',
            'rt' => 'required|string|max:5', 
            'rw' => 'required|string|max:5', 
            'nama_kelurahan' => 'required|string|max:255',
            'nama_kecamatan' => 'required|string|max:255', 
            'kabupaten_kota' => 'required|string|max:255',
            'propinsi' => 'required|string|max:255',

            // 4. Dokumen & Identitas
            'no_ktp_pic' => 'required|string|size:16|unique:sellers,no_ktp_pic', // KTP wajib 16 digit
            'foto_pic' => 'required|image|max:2048', // Maks 2MB, wajib gambar
            'file_ktp_pic' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maks 2MB, bisa PDF/Gambar
            
            // 5. Keamanan
            'password' => 'required|string|min:8',
        ];
    }
}
