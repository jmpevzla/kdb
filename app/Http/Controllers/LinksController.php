<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Link;
use Log;

class LinksController extends Controller
{
    use PaginateTrait;

    /**
     * Paginate data
     */
    private $paginate = 10;
    private $model = Link::class;
    private $routeIndex = 'links.index';
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
            'link' => ['required', 'max:255', 'url'],
            'tipo-link_id' => ['required', 'integer', 'gt:0']
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

        $query = Link::query();

        if (request('search')) {
            $query->where('descripcion', 'LIKE', '%'.request('search').'%')
                ->orWhere('link', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Links/Index', [
            'links' => $query->paginate($this->paginate),
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
        return Inertia::render('Links/Create');
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

        $link = Link::create($req);

        return $this->redirectSearchPage($link->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        return Inertia::render('Links/Show', [
            'link' => $link
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return Inertia::render('Links/Edit', [
            'link' => [
                'id' => $link->id,
                'descripcion' => $link->descripcion,
                'link' => $link->link,
                'tipo-link_id' => $link['tipo-link_id']
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        $data = $this->validateStore($request);

        $link->update($data);

        return $this->redirectSearchPage($link->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $page = $this->getPage($link->id);
        $link->delete();
        return $this->redirectWithPage($page);
    }
}
