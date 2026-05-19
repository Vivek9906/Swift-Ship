<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MongoDB is schemaless — no ALTER TABLE needed.
        // The User model now has 'phone' in $fillable.
        // No migration required for MongoDB; this is a no-op placeholder.
    }

    public function down(): void
    {
        //
    }
};
