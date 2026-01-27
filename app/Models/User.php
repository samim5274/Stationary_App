<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'gender',
        'blood_group',

        'religion',
        'nationality',
        'national_id',
        'phone',

        'email',
        'password',

        'present_address',
        'parmanent_address',

        'father_name',
        'father_contact',

        'mother_name',
        'mother_contact',

        'guardian_name',
        'guardian_contact',

        'role',
        'status',
        'joining_date',
        'remark',
        
        'photo',
        
        'otp',
        'otp_expires_at',
        
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'is_profile_completed'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_profile_completed' => 'boolean',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(PaymentDetail::class, 'user_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'user_id');
    }

}
