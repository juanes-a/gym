<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClaseRequest;
use App\Models\Clase;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClaseController extends Controller
{
    public function index()
    {
        return view("trainer.classCreate");
    }

    public function store(ClaseRequest $request)
    {
        

        $data = $request->validated();
        $data['trainer_id'] = Auth::id();

        
        // Ensure hora_clase is properly formatted (optional)
        $data['hora_clase'] = Carbon::parse($data['hora_clase'])->format('H:i:s');
        
        Clase::create($data);

        return redirect()->route('trainer.index')
            ->with('success', 'Clase creada correctamente.');
        
        
    }

    public function edit($id)
    {
        $clase = Clase::findOrFail($id);

        if (Auth::id() !== $clase->trainer_id) {
            abort(403);
        }

        return view('trainer.classEdit', [
            'clase' => $clase,
            'hora_clase_formatted' => Carbon::parse($clase->hora_clase)->format('H:i') // Pre-formatted time
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_clase' => 'required|string|max:255',
            'categoria' => 'required|string',
            'capacidad_maxima' => 'required|integer|min:1',
            'fecha_clase' => 'required|date',
            'hora_clase' => 'required|date_format:H:i',
        ]);

        $clase = Clase::findOrFail($id);

        if (Auth::id() !== $clase->trainer_id) {
            abort(403);
        }

        $clase->update($validated);

        return redirect()->route('trainer.index')
            ->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy($id)
    {
        $clase = Clase::findOrFail($id);

        if (Auth::id() !== $clase->trainer_id) {
            abort(403);
        }

        $clase->delete();

        return redirect()->route('trainer.index')
            ->with('success', 'Clase eliminada correctamente.');
    }
}