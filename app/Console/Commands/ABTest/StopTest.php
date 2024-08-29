<?php

namespace App\Console\Commands\ABTest;

use App\Enums\ABTest\TestStatusEnum;
use App\Models\ABTest\Test;
use Illuminate\Console\Command;

class StopTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ab-test:stop {name} {status}';

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
        $this->newLine(1);

        if (!$this->hasArgument('name')) {
            $this->error('No test name provided.');

            return static::FAILURE;
        }

        $test = Test::findByName($this->argument('name'));

        if ($test->status == TestStatusEnum::STOPPED) {
            $this->error('The test already stopped.');

            return static::FAILURE;
        }

        $test->update([
                'status' => TestStatusEnum::STOPPED,
                'stopped_at' => now()
            ]);

        $this->info('Test stopped.');

        $this->newLine(1);

        return static::SUCCESS;
    }
}
