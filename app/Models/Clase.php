<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;
    
    protected $table = 'clases';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['nombre_clase', 'categoria', 'capacidad_maxima', 'hora_clase','fecha_clase' ,'trainer_id'];

    protected $casts = [
        'fecha_clase' => 'datetime:Y-m-d',
        'hora_clase' => 'datetime:H:i',
    ];
    public const CATEGORIES = [
        'Cardio',
        'Fuerza',
        'Flexibilidad',
        'Mente-Cuerpo',
        'Danza',
        'Acuático'
    ];

    

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'clase_id');
    }
}
