<?php

use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Admin\MovieAttachController;
use App\Http\Controllers\Frontend\EmailController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\WatchlistController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Frontend\MovieController as FrontendMovieController;
use App\Http\Controllers\Frontend\TvShowController as FrontendTvShowController;
use App\Http\Controllers\Frontend\CastController as FrontendCastController;
use App\Http\Controllers\Frontend\GenreController as FrontendGenreController;
use App\Http\Controllers\Frontend\TagController as FrontendTagController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('index');
Route::get('/movies', [FrontendMovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [FrontendMovieController::class, 'show'])->name('movies.show');
Route::post('/movies/{movie:slug}/watchlist', [FrontendMovieController::class, 'watchlist'])->name('movies.watchlist')->middleware(['auth', 'verified']);
Route::get('/tv-shows', [FrontendTvShowController::class, 'index'])->name('tv-shows.index');
Route::get('/tv-shows/{tv_show:slug}', [FrontendTvShowController::class, 'show'])->name('tv-shows.show');
Route::post('/tv-shows/{tv_show:slug}/watchlist', [FrontendTvShowController::class, 'watchlist'])->name('tv-shows.watchlist')->middleware(['auth', 'verified']);
Route::get('/tv-shows/{tv_show:slug}/seasons/{season:slug}', [FrontendTvShowController::class, 'seasonShow'])->name('seasons.show');
Route::get('/episodes/{episode:slug}', [FrontendTvShowController::class, 'showEpisode'])->name('episodes.show');
Route::get('/casts', [FrontendCastController::class, 'index'])->name('casts.index');
Route::get('/casts/{cast:slug}', [FrontendCastController::class, 'show'])->name('casts.show');
Route::get('/genre/{genre:slug}', [FrontendGenreController::class, 'show'])->name('genres.show');
Route::get('/tags/{tag:slug}', [FrontendTagController::class, 'index'])->name('tags.index');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'editProfile']);
    Route::get('/profile/change-email', [EmailController::class, 'index'])->name('change-email');
    Route::post('/profile/change-email', [EmailController::class, 'update']);
    Route::get('/verifyEmail/{id}/{token}',[EmailController::class, 'change']);
});
Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Index', [
            'users' => \App\Models\User::count(),
            'movies' => \App\Models\Movie::count(),
            'casts' => \App\Models\Cast::count(),
            'tvShows' => \App\Models\TvShow::count()
        ]);
    })->name('index');
    Route::resource('/movies', MovieController::class);
    Route::get('/movies/{movie}/attach', [MovieAttachController::class, 'index'])->name('movies.attach');
    Route::post('/movies/{movie}/add-trailer', [MovieAttachController::class, 'addTrailer'])->name('movies.add.trailer');
    Route::post('/movies/{movie}/add-cast', [MovieAttachController::class, 'addCast'])->name('movies.add.cast');
    Route::post('/movies/{movie}/add-tag', [MovieAttachController::class, 'addTag'])->name('movies.add.tag');
    Route::post('/movies/{movie}/add-download', [MovieAttachController::class, 'addDownload'])->name('movies.add.download');
    Route::delete('/trailers-urls/{trailer_url}', [MovieAttachController::class, 'deleteTrailer'])->name('trailers.desroy');
    Route::delete('/downloads/{download}', [MovieAttachController::class, 'deleteDownload'])->name('downloads.destroy');
    Route::resource('/tv-shows', TvShowController::class);
    Route::resource('/tv-shows/{tv_show}/seasons', SeasonController::class);
    Route::resource('/tv-shows/{tv_show}/seasons/{season}/episodes', EpisodeController::class);
    Route::resource('/genres', GenreController::class);
    Route::resource('/casts', CastController::class);
    Route::resource('/tags', TagController::class);
    Route::get('/contact_us', [ContactController::class, 'index'])->name('contact_us.index');
    Route::put('/contact_us', [ContactController::class, 'update'])->name('contact_us.update');
});