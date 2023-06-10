<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable;

    public $table = 'users';

    public $fillable = [
        'full_name',
        'phone_number',
        'email',
        'password',
        'user_type',
        'image_url'
    ];

    protected $casts = [
        'full_name' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'password' => 'string',
        'user_type' => 'string',
        'image_url' => 'string'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public static array $rules = [
        'full_name' => 'required',
        'phone_number' => 'required|numeric|digits:10|unique:users,phone',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'user_type' => 'required'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier():mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
    /**
     * Get all of the projectsAsManger for the TeamMember
     */
    public function projectsAsManger():HasMany
    {
        return $this->hasMany(Project::class, 'manager_id', 'id');
    }
    /**
     * Get the teamMember associated with the User
     */
    public function teamMember(): HasOne
    {
        return $this->hasOne(TeamMember::class);
    }
}
