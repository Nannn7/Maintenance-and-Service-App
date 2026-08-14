<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * IMPORTANT: this is a custom, simplified notifications table per the PRD
 * spec (a direct user_id FK, not Laravel's polymorphic notifiable_type /
 * notifiable_id convention used by Illuminate\Notifications\DatabaseNotification).
 *
 * If you later run `php artisan notifications:table` to use Laravel's native
 * Notification::send()->database() channel, IT WILL COLLIDE with this table
 * name. Pick one: either build your own NotificationService around this
 * table, or rename this table (e.g. `app_notifications`) and let Laravel own
 * `notifications`. Flagging this now so it doesn't bite you in Phase 2.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title', 150);
            $table->text('body');
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();

            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
