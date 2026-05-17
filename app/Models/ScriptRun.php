<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScriptRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'script_key',
        'script_name',
        'status',
        'exit_code',
        'started_at',
        'finished_at',
        'summary',
        'output',
        'error_output',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'summary' => 'array',
    ];
}
