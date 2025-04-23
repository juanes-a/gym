@extends('layouts.app-master')
@section('title', 'Dashoard Trainer')
@section('content')
        @auth
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/trainer/styles.css') }}" type="text/css">
        <title>dashoard trainer</title>
        
        <div class="container mt-4">
            <header>
                <div class="header-content">
                    <div>
                        <h1>Gym Class Manager</h1>
                        <p class="subtitle">Manage your gym classes, instructors, and schedules</p>
                    </div>
                    <a href="/class" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        Add New Class
                    </a>
                </div>
            </header>
            
            <main>
                <div class="card">
                    <div class="card-header">
                        <h2>Gym Classes</h2>
                        <p class="card-description">View and manage all your gym classes</p>
                    </div>
                    <div class="card-content">
                        <table id="classes-table" class="table">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Instructor</th>
                                    <th>Category</th>
                                    <th>Schedule</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="classes-list">
                                @foreach ($clases as $clase)
                                    <tr>
                                        <td>{{ $clase->nombre_clase}}</td>
                                        <td>{{ Auth::user()->name }}</td>
                                        <td>{{ $clase->categoria }}</td>
                                        <td>{{ $clase->fecha_clase->format('Y-m-d') }} {{ \Carbon\Carbon::parse($clase->hora_clase)->format('H:i') }}</td>

                                        <td>
                                            <a href="{{ route('clase.edit', ['id' => $clase->id, 'trainer_id' => $clase->trainer_id]) }}" class="btn btn-sm btn-warning">Editar</a>
                                            
                                            <form action="{{ route('clase.destroy', $clase->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta clase?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                            </form>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">You're viewing the home page. Please login to view the restricted data.</p>
        @endguest
    </div>
@endsection
