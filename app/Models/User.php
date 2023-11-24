<?php

namespace App\Models;

use App\Casts\PersianDateCast;
use App\Traits\Authorization\HasPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'password',
//        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'birth_date' => PersianDateCast::class,
        'status' => 'bool'
    ];

//    protected function createdAt(): Attribute{
//        return Attribute::make(
//            get: fn (string $value) =>  jalaliDate($value)
//        );
//    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function mails(){
        return $this->hasMany(Mail::class);
    }

    public function scopeSearch(Builder $query, $term = null, $time = null)
    {
        return $query->when($term, function (Builder $query, $term) {
            $query->where(function ($query) use ($term) {
                $query->where('first_name', 'like', "%{$term}%")
                    ->orWhere('last_name', 'like', "%{$term}%")
                    ->orWhere('mobile', 'like', "%{$term}%")
                    ->orWhere('national_code', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        });
//        ->when($time, function (Builder $query, $time) {
//        $query->where('created_at', '<=', $time);
//    })
    }

}
