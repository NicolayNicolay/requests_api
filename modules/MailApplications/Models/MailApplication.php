<?php

namespace Modules\MailApplications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Applications\Models\Applications;
use Modules\Users\Models\User;

class MailApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'application_id',
        'text',
    ];

    protected $appends = [
        'user_data',
        'application_mail',
    ];

    public function application(): ?HasOne
    {
        return $this->HasOne(Applications::class, 'id', 'application_id') ?? null;
    }

    public function user(): ?HasOne
    {
        return $this->HasOne(User::class, 'id', 'user_id') ?? null;
    }

    public function getUserDataAttribute(): Model
    {
        return $this->user()->first();
    }
    public function getApplicationMailAttribute(): string
    {
        return $this->application()->email;
    }
}
