<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'clase_id', 'booking_date', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
