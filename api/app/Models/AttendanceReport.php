<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_report';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'status',
        'time_clocked_in',
        'time_clocked_out'
    ];

    protected $casts = [
        'time_clocked_in' => 'datetime',
        'time_clocked_out' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
