<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Authenticatable
{
    protected $primaryKey = 'id';
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'occupation',
        'experience',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación con Clase: Un Trainer tiene muchas Clases
    public function clases()
    {
        return $this->hasMany(Clase::class, 'trainer_id');
    }
}
