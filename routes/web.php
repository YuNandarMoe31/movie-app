<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Front\WelcomeController;
use App\Http\Controllers\Admin\MovieAttachController;
use App\Http\Controllers\Front\TagController as FrontTagController;
use App\Http\Controllers\Front\CastController as FrontCastController;
use App\Http\Controllers\Front\GenreController as FrontGenreController;
use App\Http\Controllers\Front\MovieController as FrontMovieController;
use App\Http\Controllers\Front\TvShowController as FrontTvShowController;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/movies', [FrontMovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [FrontMovieController::class, 'show'])->name('movies.show');
Route::get('/tv-shows', [FrontTvShowController::class, 'index'])->name('tvShows.index');
Route::get('/tv-shows/{tv_show:slug}', [FrontTvShowController::class, 'show'])->name('tvShows.show');
Route::get('/tv-shows/{tv_show:slug}/seasons/{season:slug}', [FrontTvShowController::class, 'seasonShow'])->name('season.show');
Route::get('/episodes/{episode:slug}', [FrontTvShowController::class, 'showEpisode'])->name('episodes.show');
Route::get('/casts', [FrontCastController::class, 'index'])->name('casts.index');
Route::get('/casts/{cast:slug}', [FrontCastController::class, 'show'])->name('casts.show');
Route::get('/genres/{genre:slug}', [FrontGenreController::class, 'show'])->name('genres.show');
Route::get('/tags/{tag:slug}', [FrontTagController::class, 'show'])->name('tags.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        //auth()->user()->assignRole('admin');
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Index');
    })->name('index');
    Route::resource('/movies', MovieController::class);
    Route::get('/movies/{movie}/attach', [MovieAttachController::class, 'index'])->name('movies.attach');
    Route::post('/movies/{movie}/add-trailer', [MovieAttachController::class, 'addTrailer'])->name('movies.add.trailer');
    Route::post('/movies/{movie}/add-casts', [MovieAttachController::class, 'addCast'])->name('movies.add.casts');
    Route::post('/movies/{movie}/add-tags', [MovieAttachController::class, 'addTag'])->name('movies.add.tags');
    Route::delete('/trailer-urls/{trailer_url}', [MovieAttachController::class, 'destroyTrailer'])->name('trailers.destroy');
    Route::resource('/tv-shows', TvShowController::class);
    Route::resource('/tv-shows/{tv_show}/seasons', SeasonController::class);
    Route::resource('/tv-shows/{tv_show}/seasons/{season}/episodes', EpisodeController::class);    Route::resource('/genres', GenreController::class);
    Route::resource('/casts', CastController::class);
    Route::resource('/tags', TagController::class);
});
