<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'phone', 'verification_code', 'expires_at'
    ];

    protected $dates = [
        'expires_at',
    ];
}

