<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Grupo;
use Log;

class GruposController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Grupo::class;
    private $routeIndex = 'grupos.index';
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

        $query = Grupo::query();

        if (request('search')) {
            $query->where('nombre', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Grupos/Index', [
            'grupos' => $query->select('*')->paginate($this->paginate)->withQueryString(),
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
        return Inertia::render('Grupos/Create');
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

        $grupo = Grupo::onlyTrashed()->where('nombre', '=' ,$req['nombre'])->first();

        if ($grupo != null) {
            $grupo->restore();
        } else {
            $grupo = Grupo::create($req);
        }

        return $this->redirectSearchPage($grupo->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        return Inertia::render('Grupos/Show', [
            'grupo' => $grupo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        return Inertia::render('Grupos/Edit', [
            'grupo' => [
                'id' => $grupo->id,
                'nombre' => $grupo->nombre,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grupo $grupo)
    {
        $data = $request->validate([
            'nombre' => ['required', 'max:255'],
        ]);

        $grupo->update($data);

        return $this->redirectSearchPage($grupo->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        $page = $this->getPage($grupo->id);
        $grupo->delete();
        return $this->redirectWithPage($page);
    }
}
