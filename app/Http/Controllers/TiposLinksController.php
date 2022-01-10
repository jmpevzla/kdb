<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TiposLink;
use Log;

class TiposLinksController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = TiposLink::class;
    private $routeIndex = 'tipos-links.index';
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
		    'field' => ['in:id,descripcion']
        ]);

        $query = TiposLink::query();

        if (request('search')) {
            $query->where('descripcion', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('TiposLinks/Index', [
            'tiposLinks' => $query->select('*')->paginate($this->paginate)->withQueryString(),
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
        return Inertia::render('TiposLinks/Create');
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
            'descripcion' => ['required', 'max:255'],
        ]);

        $tiposLink = TiposLink::onlyTrashed()->where('descripcion', '=' ,$req['descripcion'])->first();

        if ($tiposLink != null) {
            $tiposLink->restore();
        } else {
            $tiposLink = TiposLink::create($req);
        }

        return $this->redirectSearchPage($tiposLink->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TiposLink  $tiposLink
     * @return \Illuminate\Http\Response
     */
    public function show(TiposLink $tiposLink)
    {
        return Inertia::render('TiposLinks/Show', [
            'tiposLink' => $tiposLink
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TiposLink  $tiposLink
     * @return \Illuminate\Http\Response
     */
    public function edit(TiposLink $tiposLink)
    {
        return Inertia::render('TiposLinks/Edit', [
            'tiposLink' => [
                'id' => $tiposLink->id,
                'descripcion' => $tiposLink->descripcion,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TiposLink  $tiposLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TiposLink $tiposLink)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'max:255'],
        ]);

        $tiposLink->update($data);

        return $this->redirectSearchPage($tiposLink->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TiposLink  $tiposLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(TiposLink $tiposLink)
    {
        $page = $this->getPage($tiposLink->id);
        $tiposLink->delete();
        return $this->redirectWithPage($page);
    }
}
