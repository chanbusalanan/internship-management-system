<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyLog extends Model
{
    /** @use HasFactory<\Database\Factories\DailyLogFactory> */
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'assignment_id',
        'log_date',
        'time_in',
        'time_out',
        'activity_description',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'reviewed_by');
    }
}
