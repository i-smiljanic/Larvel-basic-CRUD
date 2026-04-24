<?php

// Import the base Migration class
use Illuminate\Database\Migrations\Migration;
// Import Blueprint — used to define the structure of the table columns
use Illuminate\Database\Schema\Blueprint;
// Import the Schema facade — used to create, modify, or drop tables
use Illuminate\Support\Facades\Schema;

// Return an anonymous migration class — no need to give it a name
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // This runs when you execute: php artisan migrate
    // It creates the 'posts' table in the database
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                            // Auto-incrementing primary key column (id)
            $table->timestamps();                    // Adds 'created_at' and 'updated_at' columns
            $table->string('title');                 // A short text column for the post title
            $table->longText('body');                // A large text column for the post content
            $table->foreignId('user_id')->constrained(); // An integer column that links to the 'users' table (foreign key)
        });
    }

    /**
     * Reverse the migrations.
     */
    // This runs when you execute: php artisan migrate:rollback
    // It removes the 'posts' table from the database
    public function down(): void
    {
        Schema::dropIfExists('posts'); // Drop the table only if it exists — avoids errors
    }
};
