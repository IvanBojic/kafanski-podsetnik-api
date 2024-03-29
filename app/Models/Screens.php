<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Screens extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'screens';

    protected $fillable = [
        'id',
        'title',
        'status',
        'active',
    ];

}
