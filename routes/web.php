<?php

// Import the PostController to handle post-related routes
use App\Http\Controllers\PostController;
// Import the UserController to handle auth-related routes
use App\Http\Controllers\UserController;
// Import the Post model (available here if needed for direct queries)
use App\Models\Post;
// Import the Route facade so we can define routes
use Illuminate\Support\Facades\Route;

// Homepage route — responds to GET requests on '/'
Route::get('/', function () {
    $posts = []; // Default to an empty array if no user is logged in

    // If a user is logged in, fetch only their posts, newest first
    // usersPosts() is the hasMany relationship defined in the User model
    if (auth()->check()) {
        $posts = auth()->user()->usersPosts()->latest()->get();
    }

    // Pass the posts to the 'home' Blade view
    return view('home', ['posts' => $posts]);
});

// --- User / Auth Routes ---

// Handle registration form submission
Route::post('/register', [UserController::class, 'register']);
// Handle logout form submission
Route::post('/logout', [UserController::class, 'logout']);
// Handle login form submission
Route::post('/login', [UserController::class, 'login']);

// --- Post Routes ---

// Handle new post form submission
Route::post('/create-post', [PostController::class, 'createPost']);
// Show the edit form for a specific post — {post} is the post ID, Laravel auto-loads the Post model
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
// Handle the edit form submission — uses PUT to match @method('PUT') in the Blade form
Route::put('/edit-post/{post}', [PostController::class, 'updatePost']);
// Handle post deletion — uses DELETE to match @method('DELETE') in the Blade form
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);