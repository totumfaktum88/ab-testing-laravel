<?php

namespace App\Models;

use App\Models\ABTest\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $session_id
 * @property string $url
 * @property string $type
 * @property array<string, mixed> $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Session $session
 */
class Event extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'session_id' => 'integer',
        'data' => 'array',
    ];

    /**
     * @return BelongsTo<Session, Event>
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function scopeByTest(Builder $query, Test $test): void {
        $query->where('test_variant_stored');
    }
}
