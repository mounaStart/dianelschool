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
        'password' => 'hashed',
    ];

    // app/Models/User.php

    public function roles()
{
    return $this->belongsToMany(Role::class, 'roles_users')->withTimestamps();
}

 
 
 public function hasRole($roles)
{
    if (is_array($roles)) {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    return $this->roles()->where('name', $roles)->exists();
}

 

public function parentEleve()
{
    return $this->hasOne(ParentEleve::class, 'user_id');
}
public function enfants()
{
    return $this->parentEleve ? $this->parentEleve->enfants() : collect();
}

public function enseignement()
{
    return $this->hasOne(Enseignement::class);
}

}
