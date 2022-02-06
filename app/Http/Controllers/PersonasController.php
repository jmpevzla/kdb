<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use App\Http\Requests\LinksPostRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Persona;
use App\Models\Apodo;
use App\Models\TiposLink;
use App\Models\Link;
use Illuminate\Validation\Rule;
use Exception;
use Log;
use Illuminate\Support\Facades\DB;
use stdClass;

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
     * Get input request service
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $key
     * @param $default
     * @return mixed
     */
    private function getInput(Request $request, string $key, $default = null)
    {
        $data = $request->input($key, $default);
        return $data == null ? $default : $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $searchLink = $this->getInput($request, 'searchLink', '');

        return Inertia::render('Personas/Create', [
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
            'apodos' => ['array'],
            'links' => ['array']
        ]);

        $persona = new stdClass;

        DB::transaction(function() use ($req, &$persona) {
            $persona = Persona::create($req);
            $persona->apodos()->createMany($req['apodos']);
            $persona->links()->attach($req['links']['selLinks']);
            $persona->links()->createMany($req['links']['createLinks']);
        });

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Persona $persona)
    {
        $searchLink = $this->getInput($request, 'searchLink', '');

        return Inertia::render('Personas/Edit', [
            'persona' => [
                'id' => $persona->id,
                'nombre' => $persona->nombre,
                'bio' => $persona->bio,
                'apodos' => $persona->apodos,
                'links' => $persona->links
            ],
            'tiposLinks' => Inertia::lazy(function() {
                return TiposLink::getDescriptions();
            }),
            'links' => Link::getLinks($searchLink)
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

        DB::transaction(function() use ($persona, $data) {
            $persona->apodos()->create($data);
        });

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

    /**
     * Create a link to the specified resource
     *
     * @param  \App\Http\Requests\LinksPostRequest  $linkPostRequest
     * @param \App\Models\Persona   $persona
     * @return \Illuminate\Http\Response
     */
    public function createLink(LinksPostRequest $linkPostRequest, Persona $persona)
    {
        $data = $linkPostRequest->validated();
        DB::transaction(function() use ($persona, $data) {
            $persona->links()->create($data);
        });
        return redirect()->back();
    }

    /**
     * Remove a link to the specified resource
     *
     * @param \App\Models\Persona $persona
     * @param int $idLink
     * @return \Illuminate\Http\Response
     */
    public function removeLink(Persona $persona, int $idLink)
    {
        $persona->links()->detach($idLink);

        return redirect()->back();
    }

    /**
     * Attach a link to the specified resource
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\Persona $persona
     * @return \Illuminate\Http\Response
     */
    public function attachLink(Request $request, Persona $persona)
    {
        $req = $request->validate([
            'id' => ['required', 'integer', 'gt:0'],
        ]);

        $idLink = $req['id'];

        $persona->links()->attach($idLink);

        return redirect()->back();
    }
}
