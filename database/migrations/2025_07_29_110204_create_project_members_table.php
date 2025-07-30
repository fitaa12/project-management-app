<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_members', function (Blueprint $table) {
            $table->id(); // Optional: A primary key for the pivot table itself, though not strictly required for many-to-many
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Foreign key to projects table
            $table->timestamps(); // Optional: created_at and updated_at

            // Add a unique constraint to prevent duplicate entries (one user can only be a member of a project once)
            $table->unique(['user_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};