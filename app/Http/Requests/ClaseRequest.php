<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; 


class ClaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_clase' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'capacidad_maxima' => 'required|integer|min:1',
            'hora_clase' => 'required|date_format:H:i',
            'fecha_clase' => 'required|date',
            'trainer_id' => 'required|exists:trainers,id'
        ];
    }
}
