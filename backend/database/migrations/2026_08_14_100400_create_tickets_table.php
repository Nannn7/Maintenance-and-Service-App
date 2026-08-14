<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 30)->unique();

            $table->foreignId('reporter_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('assigned_technician_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->foreignId('location_id')
                ->constrained('locations')
                ->restrictOnDelete();

            $table->string('title', 150);
            $table->text('description');

            $table->enum('priority_level', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'assigned', 'in_progress', 'resolved', 'closed', 'rejected'])
                ->default('open');

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('due_resolution_at')->nullable();

            $table->boolean('is_sla_breached')->default(false);

            $table->timestamps();

            $table->index('status', 'idx_ticket_status');
            // ticket_number already has a unique index (which covers idx_ticket_number's purpose)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
