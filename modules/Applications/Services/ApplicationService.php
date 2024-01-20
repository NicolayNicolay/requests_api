<?php

declare(strict_types=1);

namespace Modules\Applications\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Modules\Enums\StatusEnum;
use Modules\Projects\Models\Projects;

class ApplicationService
{
    public static function getStatusValue($value): bool
    {
        return match ($value) {
            StatusEnum::Active => false,
            StatusEnum::Resolved => true
        };
    }

    public static function getDbStatusValue($value): StatusEnum
    {
        return match ($value) {
            false => StatusEnum::Active,
            true => StatusEnum::Resolved
        };
    }
}
