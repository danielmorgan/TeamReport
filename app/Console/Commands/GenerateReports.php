<?php

namespace TeamReport\Console\Commands;

use Illuminate\Console\Command;

class GenerateReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (\Teamwork::project()->all()['projects'] as $project) {
            foreach (\Teamwork::project((int) $project['id'])->tasklists()['tasklists'] as $taskList) {
                $this->info($taskList['name']);
            }
        }
    }
}
