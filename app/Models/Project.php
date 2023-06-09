<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'projects';

    public $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'project_status',
        'manager_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'start_date' => 'datetime:Y-m-d H:00',
        'end_date' => 'datetime:Y-m-d H:00',
        'project_status' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'description' => 'sometimes',
        'start_date' => 'sometimes|date',
        'end_date' => 'required|date',
        'project_status' => 'required|in:created,waiting,pending,progress,finished',
    ];
    /**
     * Get the manager that owns the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class,'manager_id','id');
    }
    /**
     * Get all of the teamMembers for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class);
    }
    /**
     * Get all of the tasks for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
