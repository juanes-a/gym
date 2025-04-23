<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    // Muestra el formulario de login
    public function show()
    {
        return view('auth.login');
    }

    // Realiza la autenticación
    public function login(LoginRequest $request)
    {
        // Intenta autenticar al usuario como "web" (usuario normal)
        $credentials = $request->getCredentials();

        // Intentar autenticación con "web"
        if (Auth::guard('web')->attempt($credentials)) {
            return $this->authenticated($request, Auth::guard('web')->user());
        }

        // Intentar autenticación con "trainer" (entrenador)
        if (Auth::guard('trainer')->attempt($credentials)) {
            return $this->authenticated($request, Auth::guard('trainer')->user());
        }

        // Si no se pudo autenticar, redirige con error
        return redirect()->route('login.show')->withErrors(trans('auth.failed'));
    }

    // Lógica de redirección después de la autenticación exitosa
    protected function authenticated(Request $request, $user)
    {
        // Redirige según el tipo de usuario
        if ($user instanceof \App\Models\Trainer) {
            return redirect()->route('trainer.index'); // Redirige a la vista del entrenador
        }

        // Redirige a la vista del usuario normal
        return redirect()->route('user.index');
    }
}
