<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_resolutions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->unique()
                ->constrained('tickets')
                ->cascadeOnDelete();

            $table->foreignId('technician_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('action_taken');
            $table->text('parts_replaced')->nullable();

            // Geolocation anti-fraud: captured automatically on "Complete Task" (PRD section 4)
            $table->decimal('geo_latitude', 10, 8)->nullable();
            $table->decimal('geo_longitude', 11, 8)->nullable();

            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_resolutions');
    }
};
