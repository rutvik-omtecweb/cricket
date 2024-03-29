<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'gender',
        'dob',
        'address',
        'city',
        'state',
        'postal_code',
        'verification_id_1',
        'verification_id_2',
        'verification_id_3',
        'confirmation_message',
        'is_approve',
        'is_active',
        'is_verify',
        'terms_and_conditions',
        'living_rmwb_for_3_month',
        'not_member_of_cricket',
        'image',
        'is_reject',
        'rejection_reason'
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
        'password' => 'hashed',
        'is_active' => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/user/' . $value))) {
                return asset('storage/user/' . $value);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerify($query)
    {
        return $query->where('is_verify', true);
    }

    public function scopeApprove($query)
    {
        return $query->where('is_approve', true); //is_reject - 0 means reject and 1 meas approve
    }

    public function payment_collect()
    {
        return $this->hasOne(PaymentCollect::class, 'user_id', 'id');
    }

    public function team_member()
    {
        return $this->hasOne(TeamMember::class, 'member_id', 'id');
    }


    public function scopeNotRole(Builder $query, $roles, $guard = null)
    {
        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) use ($guard) {
            if ($role instanceof Role) {
                return $role;
            }

            $method = is_numeric($role) ? 'findById' : 'findByName';
            $guard = $guard ?: $this->getDefaultGuardName();

            return $this->getRoleClass()->{$method}($role, $guard);
        }, $roles);

        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->where(config('permission.table_names.roles') . '.id', '!=', $role->id);
                }
            });
        });
    }
}
