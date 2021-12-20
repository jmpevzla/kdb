<?php

namespace App\Http\Controllers\Grupos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use App\Models\Grupo;

class CreateGrupoController extends Controller
{
    private const SUCCESS = '¡Grupo creado con Exito!';
    private const ERROR = 'El grupo no pudo ser creado, intentelo nuevamente';

    /**
     * Display the grupo create view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Grupos/Create', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $grupo = Grupo::create([
            'nombre' => $request->name,
        ]);

        if (!empty($grupo)) {
            return redirect()->action([self::class, 'create'])
                ->with('status', __($this::SUCCESS));
        }

        throw ValidationException::withMessages([
            $this::ERROR
        ]);

    }
}
