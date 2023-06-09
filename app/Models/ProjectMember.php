<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProjectMember extends Model
{
     use SoftDeletes;    use HasFactory;
      public $table = 'project_members';

    public $fillable = [
        'team_member_id',
        'project_id'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'team_member_id' => 'required|exists:team_members,id',
        'project_id' => 'required|exists:projects,id'
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
     * Get the project that owns the ProjectMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
