<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class product extends Model
{
    protected $guarded = [];

    public function section(): BelongsTo
    {
        return $this->belongsTo(section::class);
    }
}
