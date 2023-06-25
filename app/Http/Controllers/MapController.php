<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\Category;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapas = Map::paginate();
        return view('maps.index', compact('mapas')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Category::select('id', 'name')->get();
        return view('maps.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $map = new Map(['name' => $request->name, 'map' => $request->map]);
        $category = Category::find($request->category_id);
        $category->maps()->save($map);
        //return redirect()->route('mapas.index')->with('status', 'Guardado con exito!');
        return response()->json([
            'name' => $map->name,
            'state' => 'done',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mapa = Map::find($id);
        return view('maps.show', compact('mapa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $map = Map::find($id);
        $map->delete();
        return response()->json([
            'name' => $map->name,
            'state' => 'done',
        ]);

    }
}
