<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Timeline
 * @package App\Models
 * @version June 9, 2023, 12:20 am EEST
 *
 * @property foreignId $task_id
 * @property string $status
 * @property string|\Carbon\Carbon $date
 * @property foreignId $updated_by
 */
class Timeline extends Model
{

    public $table = 'timelines';

    public $fillable = [
        'task_id',
        'status',
        'date',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'string',
        'date' => 'datetime:Y-m-d H:m'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'task_id' => 'required|exists:tasks,id',
        'status' => 'required|in:created,pending,on-progress,done',
        'date' => 'required'
    ];
    /**
     * Get the user that owns the Timeline
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    /**
     * Get the task that owns the Timeline
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
