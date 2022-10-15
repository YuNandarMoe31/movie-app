<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = Request::input('perPage') ?: 5;
        
        return Inertia::render('Genres/Index', [
            'genres' => Genre::query()
                ->when(Request::input('search'), function($query, $search) {
                    $query->where('title', 'like', "%{$search}%");      
                })
                ->paginate($perPage)
                ->withQueryString(),
            'filters' => Request::only(['search', 'perPage'])
        ]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $tmdb_genres = Http::get(config('services.tmdb.endpoint') . 'genre/movie/list?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if($tmdb_genres->successful()) {
            $tmdb_genres_json = $tmdb_genres->json();

            foreach($tmdb_genres_json as $single_tmdb_genre) {
                foreach($single_tmdb_genre as $tgenre) {
                    $genre = Genre::where('tmdb_id', $tgenre['id'])->first();

                    if(!$genre) {
                        Genre::create([
                            'tmdb_id' => $tgenre['id'],
                            'title' => $tgenre['name']
                        ]);
                    }
                }
            }
            return redirect()->back()
                ->with('flash.banner', 'Genre Created Successfully.');
        }
        return redirect()->back()
            ->with('flash.banner', 'API Error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
