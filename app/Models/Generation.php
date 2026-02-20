<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'content_id',
        'tokens_used',
        'cost',
        'processing_time',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
