<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    

    protected $fillable = [
        'project_id',
        'type',
        'prompt',
        'style',
        'content',
        'status',
        'error_message'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function generations(){
        return $this->hasMany(Generation::class);
    }

    protected $casts = [
        'project_id' => 'integer',
     
    ];
}
