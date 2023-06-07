<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'team_members';

    public $fillable = [
        'user_id',
        'member_type'
    ];

    protected $casts = [
        'member_type' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'required',
        'phone_number' => 'required|numeric|digits:10|unique:users,phone_number',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'member_type' => 'required'
    ];
    /**
     * Get the user that owns the TeamMember
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get all of the projects for the TeamMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(ProjectMember::class);
    }


    /**
     * Get all of the tasks for the TeamMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(TaskMember::class,'team_member_id','id');
    }
}
