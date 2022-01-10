<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Conocimiento;
use App\Models\Tipo;
use Log;

class ConocimientosController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Conocimiento::class;
    private $routeIndex = 'conocimientos.index';
    /***/

    /**
     * Validate a new or edit resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateStore(Request $request) {
        $req = $request->validate([
            'descripcion' => ['required', 'max:255'],
            'tipo_id' => ['required', 'integer', 'gt:0'],
            'contenido' => ['required'],
            'fecha_informacion' => ['nullable', 'date']
        ]);

        return $req;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
		    'field' => ['in:id,descripcion']
        ]);

        $query = Conocimiento::query();

        if (request('search')) {
            $query->where('descripcion', 'LIKE', '%'.request('search').'%')
                ->orWhere('contenido', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Conocimientos/Index', [
            'conocimientos' => $query->select('id', 'descripcion', 'tipo_id', 'updated_at')
                ->paginate($this->paginate)->withQueryString(),
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
        $tipos = Tipo::all(['id', 'nombre']);

        return Inertia::render('Conocimientos/Create', [
            'tipos' => $tipos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $this->validateStore($request);

        $conocimiento = Conocimiento::create($req);

        return $this->redirectSearchPage($conocimiento->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Conocimiento $conocimiento)
    {
        return Inertia::render('Conocimientos/Show', [
            'conocimiento' => $conocimiento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Conocimiento $conocimiento)
    {
        $tipos = Tipo::all(['id', 'nombre']);

        return Inertia::render('Conocimientos/Edit', [
            'conocimiento' => [
                'id' => $conocimiento->id,
                'descripcion' => $conocimiento->descripcion,
                'tipo_id' => $conocimiento->tipo_id,
                'contenido' => $conocimiento->contenido,
                'fecha_informacion' => $conocimiento->fecha_informacion
            ],
            'tipos' => $tipos
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conocimiento $conocimiento)
    {
        $data = $this->validateStore($request);

        $conocimiento->update($data);

        return $this->redirectSearchPage($conocimiento->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conocimiento $conocimiento)
    {
        $page = $this->getPage($conocimiento->id);
        $conocimiento->delete();
        return $this->redirectWithPage($page);
    }
}
