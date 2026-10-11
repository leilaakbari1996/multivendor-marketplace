<?php

namespace App\Models;

use App\Enums\MediaCollection;
use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'user_name',
        'mobile',
        'password',
        'type',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'mobile_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
            'status' => UserStatus::class,
        ];
    }

    //region Relationships

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles'
        )->withTimestamps();
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    //endregion

    //region Helper method

    public function isAdmin(): bool
    {
        return $this->type === UserType::ADMIN;
    }

    public function isVendor(): bool
    {
        return $this->type === UserType::VENDOR;
    }

    public function isCustomer(): bool
    {
        return $this->type === UserType::CUSTOMER;
    }

    //endregion

    //region Scopes
    public function scopeForMobile(Builder $query, string $mobile): Builder
    {
        return $query->where('mobile', $mobile);
    }
    //endregion

    //region Morphs

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', MediaCollection::AVATAR->value);
    }

    public function likedProducts(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'likeable', 'likes')->withTimestamps();
    }

    public function likedBlogs(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'likeable', 'likes')->withTimestamps();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    //endregion
}
