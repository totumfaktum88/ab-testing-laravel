<?php

namespace App\Models\ABTest;

use App\Contracts\ABTest\Model\VariantContract;
use Database\Factories\AbTest\VariantFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
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
class Variant extends Model implements VariantContract
{
    use HasFactory;

    protected $table = 'ab_test_variants';

    protected $fillable = ['name', 'target_ratio', 'ab_test_id'];

    public function getCasts(): array
    {
        return [
            ...parent::getCasts(),
            'target_ratio' => 'int'
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return VariantFactory::new();
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'ab_test_id');
    }

    public function scopeByTargetRatio(Builder $query, $by = 'asc'): void {
        $query->orderBy('target_ratio', $by);
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getTargetRatio(): int
    {
        return $this->getAttribute('target_ratio');
    }
}
