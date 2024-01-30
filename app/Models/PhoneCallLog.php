<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCallLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'call_date',
        'phone_number',
        'call_duration',
        'status',
    ];
}
