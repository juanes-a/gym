<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display all classes with optional filtering
     */
    public function index(Request $request)
    {
        $query = Clase::with(['trainer', 'bookings']);
    
        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
    
        // Filtro por fecha (usando 'fecha_clase', no 'hora_clase')
        if ($request->filled('date')) {
            $query->whereDate('fecha_clase', Carbon::parse($request->date));
        }
    
        $classes = $query->orderBy('fecha_clase')->paginate(12);
    
        // Calcular cupos y si el usuario ya reservó
        $classes->each(function($class) {
            $class->available_spots = $class->capacidad_maxima - $class->bookings->count();
            $class->is_booked = Auth::check()
                ? $class->bookings->where('user_id', Auth::id())->isNotEmpty()
                : false;
        });
    
        $categorias = Clase::CATEGORIES;
    
        return view('user.index', compact('classes', 'categorias'));
    }
    /**
     * Handle both booking and cancellation in one method
     */
    public function handleBooking(Request $request)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id',
            'action' => 'required|in:book,cancel'
        ]);
    
        $clase = Clase::findOrFail($request->clase_id);
    
        if ($request->action == 'book') {
            // Book the class
            if ($clase->bookings()->where('user_id', Auth::id())->exists()) {
                return back()->with('error', 'Ya tienes una reserva para esta clase');
            }
    
            if ($clase->capacidad_maxima <= $clase->bookings->count()) {
                return back()->with('error', 'No hay cupos disponibles');
            }
    
            Booking::create([
                'user_id' => Auth::id(),
                'clase_id' => $clase->id,
                'booking_date' => now(),
                'status' => 'confirmed'
            ]);
    
            return back()->with('success', '¡Clase reservada exitosamente!');
        } else {
            // Cancel booking sin validación de tiempo
            $booking = $clase->bookings()
                           ->where('user_id', Auth::id())
                           ->first();
    
            if (!$booking) {
                return back()->with('error', 'No tienes una reserva para esta clase');
            }
    
            $booking->delete();
    
            return back()->with('success', 'Reserva cancelada exitosamente');
        }
    }
    
    
    

    /**
     * Show class details
     */
    public function show(Clase $class)
    {
        $available_spots = $class->capacidad_maxima - $class->bookings->count();
        $is_booked = Auth::check() && $class->bookings->where('user_id', Auth::id())->isNotEmpty();
        
        return view('user.classes.show', compact('class', 'available_spots', 'is_booked'));
    }
}
