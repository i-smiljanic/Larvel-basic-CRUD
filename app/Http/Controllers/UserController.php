<?php

// Define the namespace so Laravel knows where this controller lives
namespace App\Http\Controllers;

// Import the User model so we can work with user data
use App\Models\User;
// Import Request so we can read incoming form data
use Illuminate\Http\Request;
// Import Rule so we can use advanced validation rules like "unique"
use Illuminate\Validation\Rule;

// This controller handles user authentication: login, logout, and registration
class UserController extends Controller
{
    // Handles logging in an existing user
    public function login(Request $request) {
        // Validate that both fields are filled in
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        // Try to log in using the provided name and password
        // auth()->attempt() checks the credentials against the database
        if (auth()->attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            // Regenerate the session ID to prevent session fixation attacks
            $request->session()->regenerate();
        }

        return redirect('/'); // Redirect to the homepage whether login succeeded or not
    }

    // Handles logging out the current user
    public function logout() {
        auth()->logout(); // Clear the user's session and log them out
        return redirect('/'); // Redirect back to the homepage
    }

    // Handles registering a new user
    public function register(Request $request) {
        // Validate the incoming form data with multiple rules per field
        $incomingFields = $request->validate([
            'name'     => ['required', 'min:3', 'max:30', Rule::unique('users', 'name')],   // Name must be unique in the users table
            'email'    => ['required', 'email', Rule::unique('users', 'email')],             // Must be a valid email and unique in the users table
            'password' => ['required', 'min:8', 'max:30']                                   // Password must be between 8 and 30 characters
        ]);

        // Hash the plain-text password before storing it in the database
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Create a new user record in the database
        $user = User::create($incomingFields);

        // Automatically log in the newly registered user
        auth()->login($user);

        return redirect('/'); // Redirect to the homepage after registration
    }
}
