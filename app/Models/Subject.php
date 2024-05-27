<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Subject Papers
    public function papers(): HasMany
    {
        return $this->hasMany(Paper::class);
    }

    // Active subjects
    function ScopeActiveSubject()
    {
        return $this->where('status', 1);
    }
}