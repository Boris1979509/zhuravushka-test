<?php

namespace App\Models;

use App\Models\Shop\Order;
use App\Models\Shop\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $middle_name
 * @property string $email
 * @property string $phone
 * @property string $phone_verified_status
 * @property string $verify_token
 * @property string $phone_verify_token
 * @property object $delivery_place
 * @property Carbon $phone_verify_token_expire
 * @property string $role
 */
class User extends Authenticatable
{

    use Notifiable;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_WAIT = 'wait';

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'last_name',
        'middle_name',
        'phone_verify_token',
        'phone_verified_status',
        'delivery_place',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at'       => 'datetime',
        'phone_verify_token_expire' => 'datetime',
        'delivery_place'            => 'object',
    ];

    /**
     * @return array
     */
    public static function rolesList(): array
    {
        return [
            self::ROLE_USER      => __('User'),
            //self::ROLE_MODERATOR => __('Moderator'),
            self::ROLE_ADMIN     => __('Admin'),
        ];
    }

    /**
     * @param array $data
     * @return User
     */
    public static function register($data): self
    {
        return static::create($data);
    }

    /**
     * Create New User
     * @param string $name
     * @param string $email
     * @param string $phone
     * @return mixed
     */
    public static function new($name, $email, $phone)
    {
        return static::create([
            'name'                  => Str::ucfirst($name),
            'email'                 => $email,
            'phone'                 => $phone,
            'password'              => bcrypt(Str::random()),
            'role'                  => self::ROLE_USER,
            'phone_verified_status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @return bool
     */
    public function isWait(): bool
    {
        return $this->phone_verified_status === self::STATUS_WAIT;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->phone_verified_status === self::STATUS_ACTIVE;
    }

    /**
     * @param int $id
     */
    public function addToFavorites(int $id): void
    {
        if ($this->hasInFavorites($id)) {
            throw new \DomainException('This product is already added to favorites.');
        }
        $this->favorites()->attach($id);
    }

    /**
     * @param int $id
     */
    public function addToCompares(int $id): void
    {
        if ($this->hasInCompares($id)) {
            throw new \DomainException('This product is already added to compares.');
        }
        $this->compares()->attach($id);
    }

    /**
     * @param int $id
     */
    public function removeFromFavorites($id): void
    {
        $this->favorites()->detach($id);
    }

    /**
     * @param int $id
     */
    public function removeFromCompares($id): void
    {
        $this->compares()->detach($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function hasInFavorites(int $id): bool
    {
        return $this->favorites()->where('id', $id)->exists();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function hasInCompares(int $id): bool
    {
        return $this->compares()->where('id', $id)->exists();
    }

    /**
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_favorites', 'user_id', 'product_id');
    }

    /**
     * @return BelongsToMany
     */
    public function compares(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_compares', 'user_id', 'product_id');
    }

    /**
     * @param string $role
     */
    public function changeRole($role): void
    {
        if (!array_key_exists($role, self::rolesList())) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * if registration by email
     * @return void
     */
    public function verify(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already verified.');
        }
        $this->update([
            'status'       => self::STATUS_ACTIVE,
            'verify_token' => null,
        ]);
    }
}
