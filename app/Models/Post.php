<?php

// Define the namespace so Laravel knows where this model lives
namespace App\Models;

// Import the HasFactory trait so this model can use factories (for testing/seeding)
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Import the base Model class that all Eloquent models extend
use Illuminate\Database\Eloquent\Model;

// The Post model represents a single post record in the database
class Post extends Model
{
    // Allow this model to use database factories
    use HasFactory;

    // Define which fields can be mass-assigned (e.g. via Post::create([...]))
    // Only these three fields are allowed — others will be ignored for security
    protected $fillable = ['title', 'body', 'user_id'];

    // Define the relationship: a post belongs to one user
    // Laravel will link the post to a User using the 'user_id' column
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
