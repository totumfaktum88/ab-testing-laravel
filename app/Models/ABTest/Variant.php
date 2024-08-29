<?php

namespace App\Models\ABTest;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * @property int $id
 * @property int $ab_test_id
 * @property string $name
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Test $test
 * @method Builder byTargetRatio
 */
class Variant extends Model
{
    use HasFactory;

    protected $table = 'ab_test_variants';

    protected $fillable = ['name', 'target_ratio', 'ab_test_id'];

    public function getCasts(): array
    {
        return [
            ...parent::getCasts(),
            'target_ratio' => 'float'
        ];
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'ab_test_id');
    }

    public function scopeByTargetRatio(Builder $query, $by = 'asc'): void {
        $query->orderBy('target_ratio', $by);
    }
}
