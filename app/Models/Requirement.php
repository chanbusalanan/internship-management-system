<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requirement extends Model
{
    /** @use HasFactory<\Database\Factories\RequirementFactory> */
    use HasFactory;

    protected $fillable = [
        'requirement_name',
        'description',
        'is_required',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
