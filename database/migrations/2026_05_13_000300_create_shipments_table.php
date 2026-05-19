<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('carrier_id')->constrained()->restrictOnDelete();
            $table->string('sender_name');
            $table->string('sender_city')->index();
            $table->string('receiver_name');
            $table->string('receiver_city')->index();
            $table->text('receiver_address');
            $table->decimal('weight', 8, 2);
            $table->string('dimensions');
            $table->enum('status', [
                'pending',
                'in_transit',
                'arrived_at_city',
                'out_for_delivery',
                'delivered',
                'delayed',
                'failed',
            ])->default('pending')->index();
            $table->decimal('current_lat', 10, 7)->nullable();
            $table->decimal('current_lng', 10, 7)->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->timestamp('estimated_delivery')->nullable()->index();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
