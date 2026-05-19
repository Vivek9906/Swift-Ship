<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MongoDB is schemaless — no DDL ALTER statements needed.
     * The Payment model's fields work via $fillable.
     * ContactLead model's fields work via $fillable.
     * Carrier pricing fields work via $fillable.
     * Shipment booking fields work via $fillable.
     * This migration is a no-op placeholder for MongoDB.
     */
    public function up(): void
    {
        // No DDL needed for MongoDB
    }

    public function down(): void
    {
        //
    }
};
