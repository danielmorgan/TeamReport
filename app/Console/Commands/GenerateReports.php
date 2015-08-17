<?php

namespace TeamReport\Console\Commands;

use Illuminate\Console\Command;
use Teamwork;
use Storage;

class GenerateReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate
        {--use-cached}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate reports based on tasklist titles fetched from TeamworkPM.';

    /**
     * Projects, task lists and times.
     *
     * @var array
     */
    protected $reportArray = [];

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
        if (! $this->option('use-cached')) {
            $this->info('');
            $this->cacheTasklists();
        }

        $this->generateReportJSON();
    }

    /**
     * Fetch tasklists from TeamworkPM and write to local files.
     */
    protected function cacheTasklists()
    {
        $projects = Teamwork::project()->all()['projects'];

        $this->output->progressStart(count($projects));

        foreach ($projects as $project) {
            $directory = 'tasklist-cache/';
            $filename = $directory . $project['name'];

            Storage::makeDirectory($directory);
            if (Storage::exists($filename)) {
                Storage::delete($filename);
            }

            $tasklists = Teamwork::project((int) $project['id'])->tasklists()['tasklists'];

            foreach ($tasklists as $tasklist) {
                Storage::append($filename, $tasklist['name']);
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    /**
     * Generate JSON from local tasklist cache suitable.
     */
    protected function generateReportJSON()
    {
    }

    /**
     * Seperate the time from the task list name.
     *
     * @return int|false
     */
    protected function getTasklistTime($taskList)
    {
    }

    /**
     * Seperate the name from the task list name.
     *
     * @return string
     */
    protected function getTasklistName($taskList)
    {
    }
}
