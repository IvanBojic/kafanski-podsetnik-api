<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Categories extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'categories';

    protected $fillable = [
        'id',
        'id_screen',
        'title',
        'status',
        'active',
    ];

}
