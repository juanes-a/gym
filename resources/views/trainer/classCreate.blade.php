<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Clase</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 700px;
            margin: 40px auto;
        }
        
        h1 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Crear Nueva Clase</h1>
        
        <form action="{{ route('clases.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="trainer_id" value="{!! auth()->id() !!}">

            
            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="nombre_clase" value="{{ old('nombre_clase') }}" placeholder="Yoga" required="required">
                <label for="nombre_clase">Nombre de la Clase</label>
                @error('nombre_clase')
                    <span class="text-danger text-left">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group form-floating mb-3">
                <select class="form-control" id="categoria" name="categoria" required="required">
                    <option value="">Seleccione una categoría</option>
                    <option value="Cardio" {{ old('categoria') == 'Cardio' ? 'selected' : '' }}>Cardio</option>
                    <option value="Fuerza" {{ old('categoria') == 'Fuerza' ? 'selected' : '' }}>Fuerza</option>
                    <option value="Flexibilidad" {{ old('categoria') == 'Flexibilidad' ? 'selected' : '' }}>Flexibilidad</option>
                    <option value="Mente-Cuerpo" {{ old('categoria') == 'Mente-Cuerpo' ? 'selected' : '' }}>Mente-Cuerpo</option>
                    <option value="Danza" {{ old('categoria') == 'Danza' ? 'selected' : '' }}>Danza</option>
                    <option value="Acuático" {{ old('categoria') == 'Acuático' ? 'selected' : '' }}>Acuático</option>
                </select>
                <label for="categoria">Categoría</label>
                @if ($errors->has('categoria'))
                    <span class="text-danger text-left">{{ $errors->first('categoria') }}</span>
                @endif
            </div>
            
            <div class="form-group form-floating mb-3">
                <input type="number" class="form-control" name="capacidad_maxima" value="{{ old('capacidad_maxima') }}" placeholder="20" min="1" required="required">
                <label for="capacidad_maxima">Capacidad Máxima</label>
                @if ($errors->has('capacidad_maxima'))
                    <span class="text-danger text-left">{{ $errors->first('capacidad_maxima') }}</span>
                @endif
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group form-floating">
                        <input type="date" class="form-control" name="fecha_clase" value="{{ old('fecha_clase') }}" min="{{ date('Y-m-d') }}" required>
                        <label for="fecha_clase">Fecha de la Clase</label>
                        @error('fecha_clase')
                            <span class="text-danger text-left">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-floating">
                        <input type="time" class="form-control" name="hora_clase" value="{{ old('hora_clase') }}" required>
                        <label for="hora_clase">Hora de la Clase</label>
                        @error('hora_clase')
                            <span class="text-danger text-left">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Crear Clase</button>
            </div>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>