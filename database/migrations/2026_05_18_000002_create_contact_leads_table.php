<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MongoDB creates collections on demand — no explicit DDL needed.
     * ContactLead documents will be stored in 'contact_leads' collection automatically.
     */
    public function up(): void
    {
        // No-op for MongoDB
    }

    public function down(): void
    {
        //
    }
};
