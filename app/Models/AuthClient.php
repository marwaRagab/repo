<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Military_affairs\Military_affair;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class AuthClient extends Authenticatable
{
    use HasFactory , Notifiable ;
    protected $table = 'client_new';
    protected $fillable = ['location_google_map', 'kwfinder', 'location', 'Latitude', 'Longitude', 'house_id','email','password'];
    protected $guard = 'client';
    protected $hidden = [
        'password',
        
    ];

    public function court()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function courtNew()
    {
        return $this->belongsTo(Court::class, 'governorate_id');
    }

    public function area()
    {
        return $this->belongsTo(Region::class, 'area_id');
    }

    public function installments()
    {
        return $this->hasMany(installment::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client_address()
    {
        return $this->hasMany(ClientAddress::class, 'client_id');
    }

    public function client_phone()
    {
        return $this->hasMany(ClientPhone::class, 'client_id');
    }

    public function military_clients()

    {
        return $this->hasManyThrough(Military_affair::class, Installment::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_ids');
    }
    // ministry_ids
    public function get_ministry()
    {
        return $this->belongsTo(Ministry::class,'ministry_last');
    }

    public function ministry()
    {
        return $this->hasMany(ClientMinistry::class, 'client_id');
    }

    public function boker()
    {
        return $this->belongsTo(Boker::class, 'boker_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function client_image()
    {
        return $this->hasMany(ClientImg::class, 'client_id');
    }

    public function client_banks()
    {
        return $this->hasMany(ClientBank::class, 'client_id');
    }


}
