<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Grupo;
//use Log;

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
        $grupos = Grupo::paginate($this->paginate);

        return Inertia::render('Grupos/Index', [
            'grupos' => $grupos
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
        $grupo = Grupo::create(
            $request->validate([
                'nombre' => ['required', 'max:255'],
            ])
        );

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
