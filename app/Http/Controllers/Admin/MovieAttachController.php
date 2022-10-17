<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Cast;
use Inertia\Inertia;
use App\Models\Movie;
use App\Models\TrailerUrl;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class MovieAttachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Movie $movie)
    {
        return Inertia::render('Movies/Attach', [
            'movie' => $movie,
            'trailers' => $movie->trailers,
            'casts' => Cast::all('id', 'name'),
            'tags' => Tag::all('id', 'tag_name'),
            'movieCasts' => $movie->casts,
            'movieTags' => $movie->tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addTrailer(Movie $movie)
    {
        $movie->trailers()->create(Request::validate([
            'name'    => 'required',
            'embed_html' => 'required'
        ]));
        return redirect()->back()->with('flash.banner', 'Trailer Added.');
    }

    public function addCast(Movie $movie)
    {
        $casts = Request::input('casts');
        $cast_ids = collect($casts)->pluck('id');
        $movie->casts()->sync($cast_ids);
        return redirect()->back()->with('flash.banner', 'Casts attached.');
    }

    public function addTag(Movie $movie)
    {
        $tags = Request::input('tags');
        $tag_ids = collect($tags)->pluck('id');
        $movie->tags()->sync($tag_ids);
        return redirect()->back()->with('flash.banner', 'Tags attached.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTrailer(TrailerUrl $trailerUrl)
    {
        $trailerUrl->delete();
        return redirect()->back()->with('flash.banner', 'Trailer deleted.')->with('flash.bannerStyle', 'danger');;
    }
}
