<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\SellerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'store_name',
        'store_description',
        'pic_name',
        'pic_phone',
        'pic_email',
        'pic_street',
        'pic_RT',
        'pic_RW',
        'pic_village',
        'pic_city',
        'pic_province',
        'pic_ktp_number',
        'pic_photo_path',
        'pic_ktp_file_path',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted(): void
    {
        static::creating(function ($m) {
            $m->id = (string) Str::uuid();
        });
    }

    public static function register(array $data): Seller {
        return static::create($data);
    }

    public function batal(array $data) {
        try {
            $seller = Seller::query()->find($data['id']);
            $seller->status = SellerStatus::REJECTED->name;
            $seller->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function find(string $id) {
        try {
            $seller = Seller::query()->find($id);
            if(!$seller) {
                return null;
            }
            return $seller;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function findAll() {
        try {
            $sellers = Seller::query()->get();
            if(empty($sellers)) {
                return null;
            }
            return $sellers;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function products() {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }
}
