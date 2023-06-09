<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskMember extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'task_members';

    public $fillable = [
        'team_member_id',
        'task_id',
    ];

    protected $casts = [];

    public static array $rules = [
        'team_member_id' => 'required|exists:team_members,id',
        'task_id' => 'required|exists:tasks,id',
    ];
    /**
     * Get the teamMember that owns the ProjectMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id', 'id');
    }
    /**
     * Get the task that owns the task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
