<?php

// Define the namespace so Laravel knows where this controller lives
namespace App\Http\Controllers;

// Import the Post model so we can work with post data
use App\Models\Post;
// Import Request so we can read incoming form data
use Illuminate\Http\Request;

// This controller handles all actions related to blog posts
class PostController extends Controller
{
    // Handles deleting a post
    public function deletePost(Post $post) {
        // Only allow deletion if the logged-in user owns the post
        if (auth()->user()->id === $post['user_id']) {
            $post->delete(); // Delete the post from the database
        }
        return redirect('/'); // Send the user back to the homepage
    }

    // Handles updating an existing post
    public function updatePost(Post $post, Request $request) {
        // If the logged-in user does NOT own the post, redirect them away
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        // Validate the incoming form data — both fields are required
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // Remove any HTML tags from the title and body to prevent XSS attacks
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // Save the updated title and body to the database
        $post->update($incomingFields);
        return redirect('/'); // Redirect back to the homepage after saving
    }

    // Shows the edit form for a specific post
    public function showEditScreen(Post $post) {
        // If the logged-in user does NOT own the post, redirect them away
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        // Load the 'edit-post' view and pass the post data to it
        return view('edit-post', ['post' => $post]);
    }

    // Handles creating a new post
    public function createPost(Request $request) {
        // Validate the incoming form data — both fields are required
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // Remove any HTML tags from the title and body to prevent XSS attacks
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // Attach the logged-in user's ID to the post before saving
        $incomingFields['user_id'] = auth()->id();

        // Save the new post to the database
        Post::create($incomingFields);

        return redirect('/'); // Redirect back to the homepage after creating
    }
}