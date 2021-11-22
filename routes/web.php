<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCommentController;

use Illuminate\Support\Facades\Route;


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
//     return view('home.index');
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

//The below 2 routes can be used when we are rendering simple pages
Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');
// ->middleware('auth');

Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('/secret', [HomeController::class, 'secret'])
    ->name('secret')
    ->middleware('can:home.secret');

Route::get('/single', AboutController::class);

Route::get('about', function () {
    return view('home.about');
})->name('home.about');

Route::resource('posts', 'PostsController');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Route::get('mailable', function(){
    $comment=App\Models\Comment::find(1);
    return new App\Mail\CommentPostedMarkdown($comment);
});

// $posts = [
//     1 => [
//         'title' => 'Intro to Laravel',
//         'content' => 'This is a short intro to Laravel',
//         'is_new' => true,
//         'has_new' => true
//     ],
//     2 => [
//         'title' => 'Intro to PHP',
//         'content' => 'This is a short intro to PHP',
//         'is_new' => false
//     ],
//     3 => [
//         'title' => 'Intro to Golang',
//         'content' => 'Laravel is lit',
//         'is_new' => false
//     ]
// ];

// Route::get('/recent-posts/{days_ago?}', function ($daysAgo=20){
//     return 'Posts from ' . $daysAgo . ' days ago';
// })-> name('posts.recent.index')->middleware('auth');

// Route::prefix('/posts')->name('posts.')->group(function () use ($posts) {
//     Route::get('named-route', function () use($posts) {
//         return redirect()->route('posts.show', ['id' => 1]);
//     })->name('named-route');

//     Route::get('posts', function () use ($posts) {
//         // dd(request()->all());
//         dd(request()->query('page', 1));
//         return view('posts.index', ['posts' => $posts]);
//     })->name('posts.show');

//     Route::get('/{id}', function ($id) use ($posts) {
//         abort_if(!isset($posts[$id]), 404);
//         return view('posts.show', ['post' => $posts[$id]]);
//     })->name('posts.show');

//     Route::get('json', function () use ($posts) {
//         return response()->json($posts);
//     })->name('json');
// });

Route::resource('posts', PostsController::class);
// ->only(['index', 'show', 'create', 'store', 'edit', 'update'])

// Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {
//     Route::get('reponses', function () use ($posts) {
//         return response($posts, 201)
//             ->header('Content-Type', 'application/json')
//             ->cookie('MY_COOKIE', 'Liam Poole', 3600);
//     })->name('responses');

//     Route::get('redirect', function () {
//         return redirect('/contact');
//     })->name('redirect');

//     Route::get('back', function () {
//         return back();
//     })->name('back');

//     Route::get('away', function () {
//         return redirect()->away('https://www.google.com');
//     })->name('away');

//     Route::get('download', function () {
//         return response()->download(public_path('/4035857.jpg'), 'BMW');
//     })->name('download');
// });
Auth::routes();
