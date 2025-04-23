<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clase;

class TrainerController extends Controller
{
    public function index()
    {
        $trainerId = Auth::id();

    
        $clases = Clase::where('trainer_id', $trainerId)->get();

        return view('trainer.index', compact('clases'));
    }
}
