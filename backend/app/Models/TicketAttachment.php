<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['ticket_id', 'uploaded_by', 'file_path', 'file_type'])]
class TicketAttachment extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    public const TYPE_INITIAL_REPORT = 'initial_report';

    public const TYPE_RESOLUTION_PROOF = 'resolution_proof';

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
