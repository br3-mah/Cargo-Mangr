<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_sid',
        'auth_token',
        'from_number',
        'enabled',
    ];
}