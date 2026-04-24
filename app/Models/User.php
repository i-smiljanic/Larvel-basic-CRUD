<?php

namespace App\Models;

// This line is commented out — it would force users to verify email before logging in
// use Illuminate\Contracts\Auth\MustVerifyEmail;

// Import the UserFactory for generating fake users in tests/seeding
use Database\Factories\UserFactory;
// Import the Fillable attribute — defines which fields can be mass-assigned
use Illuminate\Database\Eloquent\Attributes\Fillable;
// Import the Hidden attribute — defines which fields are hidden from JSON output
use Illuminate\Database\Eloquent\Attributes\Hidden;
// Import HasFactory trait to enable factory support
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Import Authenticatable — the base class that gives this model login/auth functionality
use Illuminate\Foundation\Auth\User as Authenticatable;
// Import Notifiable trait so this user can receive notifications (email, SMS, etc.)
use Illuminate\Notifications\Notifiable;

// Only 'name', 'email', and 'password' can be mass-assigned (e.g. via User::create([...]))
#[Fillable(['name', 'email', 'password'])]
// 'password' and 'remember_token' will never be included in JSON responses (e.g. APIs)
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    // Enable factory support and notifications for this model
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Define how certain fields should be automatically converted when read
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Treat this field as a DateTime object
            'password' => 'hashed',            // Automatically hash the password when set
        ];
    }

    // Define the relationship: a user can have many posts
    // Laravel will find all posts where 'user_id' matches this user's ID
    public function usersPosts() {
        return $this->hasMany(Post::class, 'user_id');
    }
}
