<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tipo;
use Log;

class TiposController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Tipo::class;
    private $routeIndex = 'tipos.index';
    /***/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            //'page' => ['bail|numeric|integer|gt:0']
            'direction' => ['in:asc,desc'],
		    'field' => ['in:id,nombre']
        ]);

        $query = Tipo::query();

        if (request('search')) {
            $query->where('nombre', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Tipos/Index', [
            'tipos' => $query->paginate($this->paginate),
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
        return Inertia::render('Tipos/Create');
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
        ]);

        $tipo = Tipo::onlyTrashed()->where('nombre', '=' ,$req['nombre'])->first();

        if ($tipo != null) {
            $tipo->restore();
        } else {
            $tipo = Tipo::create($req);
        }

        return $this->redirectSearchPage($tipo->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function show(Tipo $tipo)
    {
        return Inertia::render('Tipos/Show', [
            'tipo' => $tipo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipo $tipo)
    {
        return Inertia::render('Tipos/Edit', [
            'tipo' => [
                'id' => $tipo->id,
                'nombre' => $tipo->nombre,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipo $tipo)
    {
        $data = $request->validate([
            'nombre' => ['required', 'max:255'],
        ]);

        $tipo->update($data);

        return $this->redirectSearchPage($tipo->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo $tipo)
    {
        $page = $this->getPage($tipo->id);
        $tipo->delete();
        return $this->redirectWithPage($page);
    }
}
