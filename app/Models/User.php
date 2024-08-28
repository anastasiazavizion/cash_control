<?php

namespace App\Models;

use App\Enum\Role;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, LaravelPermissionToVueJS;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'provider_name',
        'provider_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setProviderTokenAttribute($value){
        return $this->attributes['provider_token'] = Crypt::crypt($value);
    }

    public function getProviderTokenAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class, 'user_id');

    }

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class);

    }

    public function scopeTodayPayments(Builder $query)
    {
        return $query->payments()->where('payment_date', date('Y-d-m'));

    }

    public function scopeAdmin(Builder $query)
    {
        return $query->role(Role::ADMIN->value);
    }
}
