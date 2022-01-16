<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Persona;
use App\Models\Apodo;
use Log;

class PersonasController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Persona::class;
    private $routeIndex = 'personas.index';
    /***/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
		    'field' => ['in:id,nombre']
        ]);

        $query = Persona::query();

        if (request('search')) {
            $query->where('nombre', 'LIKE', '%'.request('search').'%')
                ->orWhere('bio', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Personas/Index', [
            'personas' => $query->select('*')->paginate($this->paginate)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Personas/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $request->validate([
            'nombre' => ['required', 'max:255'],
            'bio' => ['max:255'],
        ]);

        $persona = Persona::create($req);

        return $this->redirectSearchPage($persona->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        return Inertia::render('Personas/Show', [
            'persona' => $persona
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        return Inertia::render('Personas/Edit', [
            'persona' => [
                'id' => $persona->id,
                'nombre' => $persona->nombre,
                'bio' => $persona->bio,
                'apodos' => $persona->apodos
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $data = $request->validate([
            'nombre' => ['required', 'max:255'],
            'bio' => ['max: 255']
        ]);

        $persona->update($data);

        return $this->redirectSearchPage($persona->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $page = $this->getPage($persona->id);
        $persona->delete();
        return $this->redirectWithPage($page);
    }

    /**
     * Create a apodo to the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Persona   $persona
     * @return \Illuminate\Http\Response
     */
    public function createApodo(Request $request, Persona $persona)
    {
        $data = $request->validate([
            'apodo' => ['required', 'max:255'],
        ]);

        $persona->apodos()->create($data);

        return redirect()->back();
    }

    /**
     * Remove a apodo to the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Apodo     $apodo
     * @return \Illuminate\Http\Response
     */
    public function removeApodo(Request $request, Apodo $apodo)
    {
        $apodo->delete();

        return redirect()->back();
    }
}
