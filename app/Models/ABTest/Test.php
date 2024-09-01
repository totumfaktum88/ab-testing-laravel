<?php

namespace App\Models\ABTest;

use App\Contracts\ABTest\Model\TestContract;
use App\Enums\ABTest\TestStatusEnum;
use Database\Factories\AbTest\TestFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $status
 * @property Carbon $stopped_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read EloquentCollection<int, Variant> $variants
 * @method Builder byRunning
 */
class Test extends Model implements TestContract
{
    use HasFactory;

    protected $table = 'ab_tests';

    protected $fillable = ['name', 'status', 'stopped_at'];

    public function getCasts() {
        return [
            ...parent::getCasts(),
            'status' => TestStatusEnum::class
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return TestFactory::new();
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public static function findByName(string $name): Model | null {
        $model = static::query()->where('name', $name)->firstOrFail();

        return $model ?? null;
    }

    public function updateStatus(TestStatusEnum $status): bool
    {
        $this->setAttribute('status', $status);
        return $this->save();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'ab_test_id');
    }

    public function scopeByRunning(Builder $query): void {
        $query->where('status', TestStatusEnum::RUNNING)
            ->whereNull('stopped_at');
    }

    public function scopeByStopped(Builder $query): void {
        $query->where('status', TestStatusEnum::STOPPED)
            ->whereNotNull('stopped_at');
    }
}
