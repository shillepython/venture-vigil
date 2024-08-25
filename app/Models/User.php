<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'referral_code',
        'email',
        'password',
        'balance',
        'min_deposit',
        'successRate',
        'sales_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    public function verifications()
    {
        return $this->hasOne(Verification::class);
    }

    public function tradingOrders()
    {
        return $this->hasMany(TradingOrder::class);
    }

    public function getSetting($setting): ?int
    {
        return $this->settings()->where('type_settings', $setting->value)->first()->value ?? null;
    }

    public function getSettingByType($type): ?int
    {
        return $this->settings()->where('type_settings', $type)->first()->value ?? null;
    }

    public function setSetting($setting, int $value): void
    {
        $this->settings()->updateOrCreate(
            ['type_settings' => $setting->value],
            ['value' => $value]
        );
    }

    public function settings()
    {
        return $this->hasMany(UserSettings::class);
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function lids()
    {
        return $this->hasMany(User::class, 'sales_id');
    }
}
