<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Conocimiento;
use App\Models\Etiqueta;
use App\Models\Tipo;
use Illuminate\Support\Facades\DB;
use Log;
use stdClass;

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
            'categorias' => ['array'],
            'etiquetas' => ['array'],
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $session = $request->session();
        $cat = $session->pull('create-categoria')[0];
        $etq = $session->pull('create-etiqueta')[0];

        $searchCats = $this->getInput($request, 'searchCats', '');
        $searchEtqs = $this->getInput($request, 'searchEtqs', '');
        $tipos = Tipo::all(['id', 'nombre']);

        return Inertia::render('Conocimientos/Create', [
            'tipos' => $tipos,
            'categorias' => Categoria::getCategorias($searchCats),
            'etiquetas' => Etiqueta::getEtiquetas($searchEtqs),
            'createCategoria' => $cat,
            'createEtiqueta' => $etq
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

        $conocimiento = new stdClass();
        DB::transaction(function() use ($req, &$conocimiento) {
            $conocimiento = Conocimiento::create($req);
            $conocimiento->categorias()->attach($req['categorias']);
            $conocimiento->etiquetas()->attach($req['etiquetas']);
        });

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Conocimiento $conocimiento)
    {
        $searchCats = $this->getInput($request, 'searchCats', '');
        $searchEtqs = $this->getInput($request, 'searchEtqs', '');

        $session = $request->session();
        $cat = $session->pull('create-categoria')[0];
        $etq = $session->pull('create-etiqueta')[0];

        $tipos = Tipo::all(['id', 'nombre']);

        $conocimiento->load(['categorias:id,nombre', 'etiquetas:id,nombre']);

        return Inertia::render('Conocimientos/Edit', [
            'conocimiento' => [
                'id' => $conocimiento->id,
                'descripcion' => $conocimiento->descripcion,
                'tipo_id' => $conocimiento->tipo_id,
                'contenido' => $conocimiento->contenido,
                'fecha_informacion' => $conocimiento->fecha_informacion,
                'categorias' => $conocimiento->categorias,
                'etiquetas' => $conocimiento->etiquetas
            ],
            'tipos' => $tipos,
            'categorias' => Categoria::getCategorias($searchCats),
            'etiquetas' => Etiqueta::getEtiquetas($searchEtqs),
            'createCategoria' => $cat,
            'createEtiqueta' => $etq
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

        DB::transaction(function() use ($data, &$conocimiento) {
            $conocimiento->update($data);
            $conocimiento->categorias()->sync($data['categorias']);
            $conocimiento->etiquetas()->sync($data['etiquetas']);
        });

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

    /**
     * Store a newly Tipo resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTipo(Request $request)
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

        return redirect()->back();
    }

    /**
     * Store a new Categoria resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createCategoria(Request $request)
    {
        $req = $request->validate([
            'nombre' => ['required', 'max:255'],
        ]);

        $cat = Categoria::onlyTrashed()->where('nombre', '=' ,$req['nombre'])->first();

        if ($cat != null) {
            $cat->restore();
        } else {
            $cat = Categoria::create($req);
        }

        $session = $request->session();
        $session->push('create-categoria', $cat);
        return redirect()->back();
    }

    /**
     * Store a new Etiqueta resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createEtiqueta(Request $request)
    {
        $req = $request->validate([
            'nombre' => ['required', 'max:255'],
        ]);

        $etq = Etiqueta::onlyTrashed()->where('nombre', '=' ,$req['nombre'])->first();

        if ($etq != null) {
            $etq->restore();
        } else {
            $etq = Etiqueta::create($req);
        }

        $session = $request->session();
        $session->push('create-etiqueta', $etq);
        return redirect()->back();
    }
}
