<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'admins';

    public $fillable = [
        'user_id',
        'access_level'
    ];

    protected $casts = [
        'access_level' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'required',
        'phone_number' => 'required|numeric|digits:10|unique:users,phone_number',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'access_level' => 'required'
    ];
    /**
     * Get the user that owns the Admin
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
