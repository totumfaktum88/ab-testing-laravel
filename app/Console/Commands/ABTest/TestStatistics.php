<?php

namespace App\Console\Commands\ABTest;

use App\Enums\ABTest\TestStatusEnum;
use App\Models\ABTest\Test;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ab-test:statistics {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->hasArgument('name')) {
            $this->error('No test name provided.');

            return static::FAILURE;
        }

        $test = Test::findByName($this->argument('name'));

        $variants = DB::table('ab_test_statistics_view')
            ->where('test_id', $test->id)
            ->get();

        $total = $variants->sum(fn($variant) => $variant->count);

        $this->newLine(2);
        $this->info('The statistics based on '.$total.' samples.');
        $this->newLine(2);
        $this->table(
            ['variant_id', 'variant_name', 'count', 'percent'],
            $variants->map(fn($variant) => [
                'variant_id' => $variant->variant_id,
                'variant_name' => $variant->variant_name,
                'count' => $variant->count,
                'percent' => (round($variant->count / $total, 4) * 100).'%'
            ])
        );
        $this->newLine(1);

        return static::SUCCESS;
    }
}
