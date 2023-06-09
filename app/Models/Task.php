<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'tasks';

    public $fillable = [
        'name',
        'task_status',
        'project_id',
        'category_id',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'name' => 'string',
        'task_status' => 'string',
        'start_date' => 'datetime:Y-m-d H:s',
        'end_date' => 'datetime:Y-m-d H:s'
    ];

    public static array $rules = [
        'name' => 'required',
        'task_status' => 'required|in:created,progress,finished',
        'project_id' => 'required|exists:projects,id',
        'category_id' => 'required|exists:task_categories,id',
        'start_date' => 'sometimes|date',
        'end_date' => 'sometimes|date'
    ];
    /**
     * Get the category that owns the categoryMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id', 'id');
    }
    /**
     * Get the project that owns the task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    /**
     * Get all of the team members for the task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(TaskMember::class);
    }
    /**
     * Get all of the timelines for the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelines()
    {
        return $this->hasMany(Timeline::class, 'task_id', 'id');
    }
}
