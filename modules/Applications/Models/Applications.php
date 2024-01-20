<?php

namespace Modules\Applications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Enums\StatusEnum;

class Applications extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment',
        'updated_at',
    ];

    protected $casts = [
        'status' => StatusEnum::class
    ];

    public function getUpdatedAtColumn()
    {
        return null;
    }
}
