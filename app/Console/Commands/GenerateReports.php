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
     * Name of folder the project tasklists will be stored in, within storage/app/.
     *
     * @var string
     */
    protected $tasklistCacheDirectory = 'tasklist-cache';

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
            $this->comment('Downloading projects from Teamwork:');
            $this->cacheTasklists();
        }

        $this->comment('Generating Report:');
        $report = $this->generateReportJSON();
        if (Storage::put('report-' . time() . '.json', $report)) {
            Storage::put('report-latest.json', $report);
            $this->comment("\n\rReport saved successfully!");
        }
    }

    /**
     * Fetch tasklists from TeamworkPM API and write to local files.
     */
    protected function cacheTasklists()
    {
        $projects = Teamwork::project()->all()['projects'];

        $this->output->progressStart(count($projects));

        foreach ($projects as $project) {
            $id = (int) $project['id'];
            $tasklists = Teamwork::project($id)->tasklists()['tasklists'];
            $filename = $this->tasklistCacheDirectory . '/' . $project['name'];

            Storage::makeDirectory($this->tasklistCacheDirectory);
            if (Storage::exists($filename)) {
                Storage::delete($filename);
            }

            foreach ($tasklists as $tasklist) {
                Storage::append($filename, $tasklist['name']);
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    /**
     * Returns JSON encoded report data.
     */
    protected function generateReportJSON()
    {
        $parsedTasklists = $this->parseTasklistTitles();
        return json_encode($parsedTasklists, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate JSON from local tasklist cache suitable.
     *
     * @return array $report
     */
    protected function parseTasklistTitles()
    {
        $projectFiles = Storage::allFiles($this->tasklistCacheDirectory);

        foreach ($projectFiles as $projectFilename) {
            $projectName = explode('/', $projectFilename)[1];
            $tasklists = Storage::get($projectFilename);
            $tasklists = str_replace("\r", '', $tasklists);
            $tasklists = explode("\n", $tasklists);
            $report[$projectName] = [];

            $table = [];

            foreach ($tasklists as $tasklist) {
                $name = $this->getTasklistName($tasklist);
                $time = $this->getTasklistTime($tasklist);

                if ($name && $time) {
                    $report[$projectName][$name] = $time;

                    $table[] = ['name' => $name, 'time' => $time];
                }
            }

            if (! empty($table)) {
                $this->info("\n\r" . $projectName);
                $this->table(['Tasklist', 'Time'], $table);
            }
        }

        return $report;
    }

    /**
     * Seperate the name from the task list name.
     *
     * @return string $name
     */
    protected function getTasklistName($taskList)
    {
        $parenthesisPosition = strpos($taskList, '(');
        $name = substr($taskList, 0, $parenthesisPosition);
        $name = trim($name);

        return $name;
    }

    /**
     * Seperate the time from the task list name.
     *
     * @return int|false
     */
    protected function getTasklistTime($taskList)
    {
        strtok($taskList, '(');
        $time = strtok(')');

        return $this->formatTime($time);
    }

    /**
     * Read the time budget and convert it into a single format.
     *
     * @todo implement
     * @param float $time
     */
    protected function formatTime($time)
    {
        $time = strtolower($time);
        $time = preg_replace('/(hours|hour|hrs|hr|h)/', '', $time);
        $time = trim($time);

        return (float) $time;
    }
}
