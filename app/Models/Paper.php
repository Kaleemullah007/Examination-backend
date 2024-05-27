<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paper extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Paper belongs to which subject
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    // Paper questions
    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
