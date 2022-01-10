<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Etiqueta;
use Log;

class EtiquetasController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Etiqueta::class;
    private $routeIndex = 'etiquetas.index';
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

        $query = Etiqueta::query();

        if (request('search')) {
            $query->where('nombre', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Etiquetas/Index', [
            'etiquetas' => $query->select('*')->paginate($this->paginate)->withQueryString(),
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
        return Inertia::render('Etiquetas/Create');
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

        $etiqueta = Etiqueta::onlyTrashed()->where('nombre', '=' ,$req['nombre'])->first();

        if ($etiqueta != null) {
            $etiqueta->restore();
        } else {
            $etiqueta = Etiqueta::create($req);
        }

        return $this->redirectSearchPage($etiqueta->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etiqueta  $etiqueta
     * @return \Illuminate\Http\Response
     */
    public function show(Etiqueta $etiqueta)
    {
        return Inertia::render('Etiquetas/Show', [
            'etiqueta' => $etiqueta
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Etiqueta  $etiqueta
     * @return \Illuminate\Http\Response
     */
    public function edit(Etiqueta $etiqueta)
    {
        return Inertia::render('Etiquetas/Edit', [
            'etiqueta' => [
                'id' => $etiqueta->id,
                'nombre' => $etiqueta->nombre,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Etiqueta $etiqueta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etiqueta $etiqueta)
    {
        $data = $request->validate([
            'nombre' => ['required', 'max:255'],
        ]);

        $etiqueta->update($data);

        return $this->redirectSearchPage($etiqueta->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etiqueta  $etiqueta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etiqueta $etiqueta)
    {
        $page = $this->getPage($etiqueta->id);
        $etiqueta->delete();
        return $this->redirectWithPage($page);
    }
}
