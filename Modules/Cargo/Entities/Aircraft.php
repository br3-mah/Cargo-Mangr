<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $table = 'aircraft';
    protected $fillable = [
        'name',
        'type',
        'status',
        'description',
    ];
} 