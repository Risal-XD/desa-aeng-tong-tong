<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PopulationStatistic extends Model
{
    protected $fillable = [
        'statistics_id',
        'label',
        'value',
        'unit',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function statistic(): BelongsTo
    {
        return $this->belongsTo(Statistic::class, 'statistics_id');
    }
}
