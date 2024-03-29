<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel'
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP'
    ],
    2 => [
        'title' => 'A 3rd post for testing purpose',
        'content' => 'This is just another post'
    ]
];

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

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');
// <
// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

// Route::view('/', 'home.index')
//     ->name('home.index');
//
// Route::view('/contact', 'home.contact')
//     ->name('home.contact');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/secret', [HomeController::class, 'secret'])
    ->name('home.secret')
    ->middleware('can:home.secret');

Route::get('/bs-flex', function () {
    return view('bootstrap-flex');
})->name('bs-flex');

Route::get('/single', AboutController::class);

Route::resource('posts', PostController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
Route::resource('posts.comments', PostCommentController::class)->only(['index', 'store']);
Route::resource('posts.image', PostImageController::class)->only(['destroy']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);

Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');

Route::get('mailable', function () {
    $comment = App\Models\Comment::find(1);
    return new App\Mail\CommentPostedMarkdown($comment);
});

// Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore'); // TODO

// Route::get('/posts', function () use ($posts) {
//     // dd(request()->all());
//     dd((int)request()->query('page', 1));
//     return view('posts.index', ['posts' => $posts]);
// });
//
// Route::get('/posts/{id}', function ($id) use ($posts) {
//     abort_if(!isset($posts[$id]), 404);
//
//     return view('posts.show', ['post' => $posts[$id]]);
// })
// // ->where([
// //     'id' => '[0-9]+'
// // ])
//     ->name('posts.show');

Route::get('/recent-posts/{days_ago?}', function ($daysAgo=20) {
    return "Posts from $daysAgo days ago";
})->name('posts.recent.index')->middleware('auth');

Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {
    Route::get('responses', function () use ($posts) {
        return response($posts, 201)
            ->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Jean-Daniel Dumas', 3600);
    })->name('responses');

    Route::get('redirect', function () {
        return redirect('/contact');
    })->name('redirect');

    Route::get('back', function () {
        return back();
    })->name('back');

    Route::get('named-route', function () {
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named-route');

    Route::get('away', function () {
        return redirect()->away('https://google.com');
    })->name('away');

    Route::get('json', function () use ($posts) {
        return response()->json($posts);
    })->name('json');

    Route::get('download', function () {
        return response()->download(public_path('/daniel.jpg'), 'face.jpg');
    })->name('download');
});

Auth::routes();
