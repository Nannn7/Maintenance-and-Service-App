<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Applies the decision locked in review: keep the custom PRD notifications
 * schema (direct user_id FK, title/body/data/read_at columns) but rename
 * the table so the default `notifications` name stays free for Laravel's
 * native Notification::send()->database() channel later on (queued mail +
 * push per PRD section 7 will most likely want that later).
 *
 * A separate migration (instead of editing the original create migration)
 * because we can't be sure `notifications` hasn't already been migrated
 * somewhere — renaming is safe either way, editing history isn't.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('notifications', 'app_notifications');
    }

    public function down(): void
    {
        Schema::rename('app_notifications', 'notifications');
    }
};
