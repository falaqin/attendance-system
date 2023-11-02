<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class PatchScript extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patch {script}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute a script.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $function_name = $this->argument('script');

        if ($function_name and method_exists($this, $function_name)) {
            $this->$function_name();
            $this->line('Script executed.');
            return;
        }
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'script' => ['Which script do you want to execute?', 'E.g. any_function_name without parenthesis']
        ];
    }

    /**
     * 01/11/2023 - Added settings for work hour time.
     *
     * @return void
     */
    private function add_late_time_setting() : void
    {
        $timestamps = [
            'created_at' => now(),
            'updated_at' => now()
        ];

        $defaultStartValue = '09:00';
        $defaultEndValue = '18:00';

        // Check if settings already exist
        $settings = \App\Models\Setting::whereIn('key', ['start_working_hours', 'end_working_hours'])->get();

        if ($settings->count() == 2) {
            $this->error('Settings already exist!');
            return;
        }

        \App\Models\Setting::insert([
            ['key' => 'start_working_hours', 'value' => $defaultStartValue, ...$timestamps],
            ['key' => 'end_working_hours', 'value' => $defaultEndValue, ...$timestamps]
        ]);

        $this->line('New settings created');
        return;
    }
}
