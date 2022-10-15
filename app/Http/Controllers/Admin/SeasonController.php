<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TvShow $tvShow)
    {
        $perPage = Request::input('perPage') ?: 5;
        
        return Inertia::render('TvShows/Seasons/Index', [
            'seasons' => Season::query()
                ->where('tv_show_id', $tvShow->id)
                ->when(Request::input('search'), function($query, $search) {
                    $query->where('name', 'like', "%{$search}%");      
                })
                ->paginate($perPage)
                ->withQueryString(),
            'filters' => Request::only(['search', 'perPage']),
            'tvShow' => $tvShow
        ]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TvShow $tvShow)
    {
        $season = $tvShow->seasons()->where('season_number', Request::input('seasonNumber'))->exists();        
        if ($season) {
            return redirect()->back()->with('flash.banner', 'Season Exists.');
        }

        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '/season/' . Request::input('seasonNumber') . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_season->successful()) {
            Season::create([
                'tmdb_id' => $tmdb_season['id'],
                'tv_show_id' => $tvShow['id'],
                'name'    => $tmdb_season['name'],
                'slug'    => Str::slug($tmdb_season['name']),
                'poster_path' => $tmdb_season['poster_path'],
                'season_number' => $tmdb_season['season_number']
            ]);
            return redirect()->back()->with('flash.banner', 'Season created.');
        } else {
            return redirect()->back()->with('flash.banner', 'Api error.');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TvShow $tvShow, Season $season)
    {
        return Inertia::render('TvShows/Seasons/Edit', [
            'tvShow' => $tvShow,
            'season' => $season
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TvShow $tvShow, Season $season)
    {
        $validated = Request::validate([
            'name' => 'required',
            'poster_path' => 'required',
        ]);

        $season->update($validated);

        return redirect()->route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Season updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TvShow $tvShow, Season $season)
    {
        $season->delete();

        return redirect()->route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Season deleted successfully.');
    }
}
