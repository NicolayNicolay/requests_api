<?php

declare(strict_types=1);

namespace Modules\Applications\Filters;

use App\Exceptions\SomethingWrongException;
use App\ModelFilters\UserFilter;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Enums\StatusEnum;

class ApplicationFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];


    public function __construct($query, array $input = [], bool $relationsEnabled = true)
    {
        parent::__construct($query, $input, $relationsEnabled);
    }

    public function moderation($value): ApplicationFilter
    {
        $result = match ($value) {
            'true' => StatusEnum::Active,
            default => null
        };
        if ($result) {
            return $this->where('status', $result->value);
        }
        return $this;
    }

    public function createdAtStart(string $dateStart): ApplicationFilter
    {
        return $this->where('created_at', '>=', $dateStart . ' 00:00:00');
    }

    public function createdAtEnd(string $dateEnd): ApplicationFilter
    {
        return $this->where('created_at', '<=', $dateEnd . ' 00:00:00');
    }
}
