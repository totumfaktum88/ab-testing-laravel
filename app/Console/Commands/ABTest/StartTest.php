<?php

namespace App\Console\Commands\ABTest;

use App\Enums\ABTest\TestStatusEnum;
use App\Models\ABTest\Test;
use Illuminate\Console\Command;

class StartTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ab-test:start {name}';

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

        if ($test->status == TestStatusEnum::RUNNING) {
            $this->error('The test already started.');

            return static::FAILURE;
        }

        $test->update([
            'status' => TestStatusEnum::RUNNING,
            'stopped_at' => now()
        ]);

        $this->info('Test started.');

        $this->newLine(1);

        return static::SUCCESS;
    }
}
