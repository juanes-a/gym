@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <div class="container">
            <h1>Gym Classes</h1>
            <p class="lead">View and book available fitness classes.</p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="container py-4">
                <h1>Clases Disponibles</h1>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form class="row g-2">
                            <div class="col-md-5">
                            <select name="categoria" class="form-select">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $category)
                                    <option value="{{ $category }}" {{ request('categoria') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>

                            </div>
                            <div class="col-md-5">
                                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($classes as $class)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $class->nombre_clase }}</h5>
                                <div class="mb-2">
                                    <span class="badge bg-primary">{{ $class->categoria }}</span>
                                    <span class="badge bg-{{ $class->available_spots > 0 ? 'success' : 'danger' }} ms-1">
                                        {{ $class->available_spots }} cupos
                                    </span>
                                    @if($class->is_booked)
                                        <span class="badge bg-info ms-1">Reservado</span>
                                    @endif
                                </div>
                                <p class="card-text">
                                    @php
                                        // Safely parse the date and time
                                        $fechaClase = $class->fecha_clase ? \Carbon\Carbon::parse($class->fecha_clase) : null;
                                        $horaClase = $class->hora_clase ? \Carbon\Carbon::parse($class->hora_clase) : null;
                                    @endphp
                                    
                                    @if($fechaClase)
                                        <i class="far fa-calendar"></i> {{ $fechaClase->format('d M Y') }}<br>
                                    @endif
                                    
                                    @if($horaClase)
                                        <i class="far fa-clock"></i> {{ $horaClase->format('h:i A') }}<br>
                                    @endif
                                    
                                    <i class="fas fa-user-tie"></i> {{ $class->trainer->nombre }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user.classes.show', $class) }}" class="btn btn-sm btn-outline-primary">
                                        Ver detalles
                                    </a>
                                    
                                    @auth
                                    <form method="POST" action="{{ route('user.bookings.handle') }}">
                                        @csrf
                                        <input type="hidden" name="clase_id" value="{{ $class->id }}">
                                        <input type="hidden" name="action" value="{{ $class->is_booked ? 'cancel' : 'book' }}">
                                        
                                        @if($class->is_booked)
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Cancelar
                                            </button>
                                        @elseif($class->available_spots > 0)
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Reservar
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                Lleno
                                            </button>
                                        @endif
                                    </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $classes->links() }}
                </div>
            </div>
        @endauth

        @guest
        <h1>Welcome to Our Gym</h1>
        <p class="lead">Please login to view and book our fitness classes.</p>
        <div class="d-flex gap-2">
            <a href="{{ route('login.perform') }}" class="btn btn-lg btn-primary">Login</a>
            <a href="{{ route('register.show') }}" class="btn btn-lg btn-outline-secondary">Register</a>
        </div>
        @endguest
    </div>
@endsection

@section('styles')
<style>
    .card {
        transition: all 0.2s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection