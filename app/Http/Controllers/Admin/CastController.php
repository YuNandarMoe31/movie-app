<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cast;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = Request::input('perPage') ?: 5;
        return Inertia::render('Casts/Index', [
            'casts' => Cast::query()
                ->when(Request::input('search'), function($query, $search) {
                    $query->where('name', 'like', "%{$search}%");      
                })
                ->paginate($perPage)
                ->withQueryString(),
            'filters' => Request::only(['search', 'perPage'])
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
        $cast = Cast::where('tmdb_id', Request::input('castTMDBId'))->first();

        if($cast) {
            return redirect()->back()
            ->with('flash.banner', 'Cast Exists.');
        }

        $tmdb_cast = Http::get(config('services.tmdb.endpoint').'person/'. Request::input('castTMDBId') .'?api_key='. config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_cast) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name'    => $tmdb_cast['name'],
                'slug'    => Str::slug($tmdb_cast['name']),
                'poster_path' => $tmdb_cast['profile_path']
            ]);
            return redirect()->back()
                ->with('flash.banner', 'Cast Created Successfully.');
        } else {
            return redirect()->back()
                ->with('flash.banner', 'API Error.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cast $cast)
    {
        return Inertia::render('Casts/Edit', [
            'cast' => $cast
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cast $cast)
    {
        $validated = Request::validate([
            'name' => 'required',
            'poster_path' => 'required'
        ]);

        $cast->update($validated);

        return redirect()->route('admin.casts.index')
            ->with('flash.banner', 'Cast Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cast $cast)
    {
        $cast->delete();
        return redirect()->route('admin.casts.index')
            ->with('flash.banner', 'Cast Deleted Successfully.');
    }
}
