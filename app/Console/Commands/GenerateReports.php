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
    protected $signature = 'reports:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $projects = Teamwork::project()->all()['projects'];
        foreach ($projects as $project) {
            $directory = 'project-tasklists/';
            $filename = $directory . $project['name'] . '.log';

            Storage::makeDirectory($directory);
            if (Storage::exists($filename)) {
                Storage::delete($filename);
            }

            $taskLists = Teamwork::project((int) $project['id'])->tasklists()['tasklists'];
            foreach ($taskLists as $taskList) {
                $time = $this->getTimeFromTaskList($taskList['name']);
                if ($time) {
                    $this->reportArray[$project['name']][$taskList['name']] = $time;
                }

                Storage::append($filename, $taskList['name']);
            }
        }

        $this->info(print_r($this->reportArray));
    }

    /**
     * Seperate the time from the task list name.
     *
     * @return int|false
     */
    protected function getTimeFromTaskList($taskListName)
    {
        preg_match_all('/\(([0-9 ]+?)\)/', $taskListName, $out);

        if (isset($out[0][0])) {
            return $out[0][0];
        }

        return false;
    }
}
