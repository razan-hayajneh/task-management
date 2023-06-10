<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'reports';

    public $fillable = [
        'name',
        'content',
        'project_id',
        'task_id',
        'created_by'
    ];

    protected $casts = [
        'name' => 'string',
        'content' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'content' => 'required',
        'project_id' => 'required|exists:projects,id',
        'task_id' => 'required|exists:tasks,id'
    ];

    /**
     * Get the project that owns the report
     */
    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * Get the task that owns the report
     */
    public function task():BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    /**
     * Get the user that owns the report
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
