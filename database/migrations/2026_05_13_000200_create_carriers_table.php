<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carriers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['air', 'ground', 'sea'])->index();
            $table->string('contact_email');
            $table->unsignedTinyInteger('on_time_rate')->default(92);
            $table->decimal('rating', 2, 1)->default(4.2);
            $table->unsignedInteger('active_shipments')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carriers');
    }
};
