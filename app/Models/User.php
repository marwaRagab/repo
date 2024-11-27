<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function region()
    {
        return $this->hasMany(Region::class, 'created_by');
    }

    public function bank()
    {
        return $this->hasMany(Bank::class, 'created_by');
    }

    public function branch()
    {
        return $this->hasMany(Branch::class, 'created_by');
    }

    public function court()
    {
        return $this->hasMany(Court::class, 'created_by');
    }

    public function governorate()
    {
        return $this->hasMany(Governorate::class, 'created_by');
    }

    public function installment_percentage()
    {
        return $this->hasMany(Installment_Percentage::class, 'created_by');
    }

    public function ministry_percentage()
    {
        return $this->hasMany(Ministry_Percentage::class, 'created_by');
    }

    public function ministry()
    {
        return $this->hasMany(Ministry::class, 'created_by');
    }

    public function nationality()
    {
        return $this->hasMany(Nationality::class, 'created_by');
    }

    public function police_station()
    {
        return $this->hasMany(Police_station::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(member::class, 'created_by');
    }

    public function Installment_Client()
    {
        return $this->hasMany(Installment_Client::class, 'created_by');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
