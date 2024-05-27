<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }
    public function subject(): BelongsTo
    {
        return $this->belongsTo(subject::class);
    }

    public function user_answer():HasMany{
        return $this->hasMany(Examination::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
