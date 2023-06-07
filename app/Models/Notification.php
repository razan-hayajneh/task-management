<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notification extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'notifications';

    public $fillable = [
        'user_id',
        'message',
        'title'
    ];

    protected $casts = [
        'message' => 'string',
        'title' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'required|exists:users,id',
        'message' => 'required',
        'title' => 'required'
    ];


}
