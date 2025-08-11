<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateDailySchedules extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'schedules:create-daily
                           {--days=5 : Number of days to create schedules for}
                           {--clear : Clear existing schedules before creating new ones}';

    /**
     * The console command description.
     */
    protected $description = 'Create daily train schedules for specified number of days from today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $clear = $this->option('clear');

        $this->info("Creating daily schedules for {$days} days starting from today...");

        if ($clear) {
            $this->warn('This will clear all existing schedules and prices!');
            if (!$this->confirm('Do you want to continue?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        try {
            // Pass days parameter to seeder through environment
            putenv("SCHEDULE_DAYS={$days}");

            $exitCode = Artisan::call('db:seed', [
                '--class' => 'DailyScheduleSeeder'
            ]);

            if ($exitCode === 0) {
                $this->info('Daily schedules created successfully!');
                $output = Artisan::output();
                if ($output) {
                    $this->line($output);
                }
            } else {
                $this->error('Seeder returned non-zero exit code: ' . $exitCode);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('Failed to create daily schedules: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
