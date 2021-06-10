<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function brand()
    {
        return $this->hasOne('GeoAlgo\Products\Models\Brand','user_id','id');
    }

    public function VendorAddress()
    {
        return $this->hasOne('GeoAlgo\Products\Models\VendorAddress','user_id','id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\UserAddress','user_id','id');

    }

    public function vaddress()
    {
        return $this->hasOne('GeoAlgo\Products\Models\VendorAddress','user_id','id');

    }

    public function addressVendor()
    {
        return $this->hasOne('App\Models\UserAddress','user_id','id');

    }

    
}
