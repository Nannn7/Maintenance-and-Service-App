<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'title', 'body', 'data'])]
class Notification extends Model
{
    use HasFactory, HasUuids;

    /**
     * Renamed from 'notifications' -> 'app_notifications' so Laravel's
     * native Notification::send()->database() channel (polymorphic
     * notifiable_type/notifiable_id schema) can own the default table
     * name if/when we adopt it, without a naming collision.
     */
    protected $table = 'app_notifications';

    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
