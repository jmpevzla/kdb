<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Medio;
use App\Models\TiposLink;
use App\Models\Link;
use Illuminate\Support\Facades\DB;
use Log;

class MediosController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Medio::class;
    private $routeIndex = 'medios.index';
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

        $query = Medio::query();

        if (request('search')) {
            $query->where('nombre', 'LIKE', '%'.request('search').'%')
                ->orWhere('bio', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Medios/Index', [
            'medios' => $query->select('*')->paginate($this->paginate)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $searchLink = $request->input('searchLink', '');

        return Inertia::render('Medios/Create', [
            'tiposLinks' => Inertia::lazy(function() {
                return TiposLink::getDescriptions();
            }),
            'links' => Link::getLinks($searchLink)
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
        $req = $request->validate([
            'nombre' => ['required', 'max:255'],
            'bio' => ['max:255'],
            'links' => ['array'],
        ]);

        $medio = Medio::onlyTrashed()->where('nombre', '=' ,$req['nombre'])->first();

        DB::transaction(function() use ($req, &$medio) {
            if ($medio != null) {
                $medio->restore();
            } else {
                $medio = Medio::create($req);
            }

            $medio->links()->attach($req['links']['selLinks']);
            $medio->links()->createMany($req['links']['createLinks']);
        });

        return $this->redirectSearchPage($medio->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function show(Medio $medio)
    {
        return Inertia::render('Medios/Show', [
            'medio' => $medio
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function edit(Medio $medio)
    {
        return Inertia::render('Medios/Edit', [
            'medio' => [
                'id' => $medio->id,
                'nombre' => $medio->nombre,
                'bio' => $medio->bio
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medio $medio)
    {
        $data = $request->validate([
            'nombre' => ['required', 'max:255'],
            'bio' => ['max: 255']
        ]);

        $medio->update($data);

        return $this->redirectSearchPage($medio->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medio $medio)
    {
        $page = $this->getPage($medio->id);
        $medio->delete();
        return $this->redirectWithPage($page);
    }
}
