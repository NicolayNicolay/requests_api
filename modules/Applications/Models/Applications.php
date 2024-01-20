<?php

namespace Modules\Applications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Applications\Filters\ApplicationFilter;
use Modules\Enums\StatusEnum;
use EloquentFilter\Filterable;

class Applications extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment',
        'updated_at',
        'user_id'
    ];

    protected $casts = [
        'status'     => StatusEnum::class,
        'created_at' => 'date:d.m.Y H:i:s',
        'updated_at' => 'date:d.m.Y H:i:s',
    ];
    protected $appends = [
        'short_text',
        'status_name',
    ];

    public function getUpdatedAtColumn()
    {
        return null;
    }

    public function getShortTextAttribute(): string
    {
        if ($this->message) {
            return strlen($this->message) > 200 ? substr($this->message, 0, 200) . '...' : $this->message;
        } else {
            return '';
        }
    }

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            StatusEnum::Active => 'На модерации',
            StatusEnum::Resolved => 'Одобрено',
        };
    }

    public function modelFilter(): string
    {
        return $this->provideFilter(ApplicationFilter::class);
    }
}
