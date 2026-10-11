<?php

namespace App\Models;

use App\Enums\ContactMessageStatus;
use App\Enums\ContactSubject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'message',
        'status',
        'ip',
    ];

    protected $casts = [
        'subject' => ContactSubject::class,
        'status' => ContactMessageStatus::class,
    ];

    /* ---------- Scopes ---------- */

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', ContactMessageStatus::NEW);
    }

    public function scopeRead(Builder $query): Builder
    {
        return $query->where('status', ContactMessageStatus::READ);
    }

    public function scopeReplied(Builder $query): Builder
    {
        return $query->where('status', ContactMessageStatus::REPLIED);
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('status', ContactMessageStatus::ARCHIVED);
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereIn('status', [
            ContactMessageStatus::NEW,
            ContactMessageStatus::READ,
        ]);
    }

    /* ---------- Helpers ---------- */

    public function isNew(): bool
    {
        return $this->status === ContactMessageStatus::NEW;
    }

    public function markAsRead(): bool
    {
        if ($this->status !== ContactMessageStatus::NEW) {
            return true;
        }

        return $this->update([
            'status' => ContactMessageStatus::READ,
        ]);
    }

    public function markAsReplied(): bool
    {
        return $this->update([
            'status' => ContactMessageStatus::REPLIED,
        ]);
    }

    public function archive(): bool
    {
        return $this->update([
            'status' => ContactMessageStatus::ARCHIVED,
        ]);
    }
}
