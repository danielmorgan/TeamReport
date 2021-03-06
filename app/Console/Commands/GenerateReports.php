<?php

namespace TeamReport\Console\Commands;

use Illuminate\Console\Command;
use Bus;
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
        {amount? : The amount of projects you want to retrieve (for testing purposes).}
        {--queue : Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate reports based on tasklist titles fetched from TeamworkPM.';

    /**
     * Create a new command instance.
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
        if ($this->option('queue')) {
            $this->comment('Report generation added to queue.');
            Bus::dispatch(new \TeamReport\Jobs\GenerateReports());
        } else {
            $this->comment('Downloading projects from Teamwork:');
            $this->generateReport();
        }
    }

    /**
     * Fetch tasklists from TeamworkPM API and write to local files.
     */
    protected function generateReport()
    {
        $tasklistsArray = [];

        $projects = Teamwork::project()->all()['projects'];
        $this->output->progressStart(count($projects));

        $i = 0;

        foreach ($projects as $project) {
            if (! $this->argument('amount') || $i < $this->argument('amount')) {
                $projectId = (int) $project['id'];
                $tasklistsArray[$projectId] = [];
                $tasklistsArray[$projectId]['id'] = $projectId;
                $tasklistsArray[$projectId]['name'] = $project['name'];
                $tasklistsArray[$projectId]['company'] = $project['company']['name'];

                $tasklists = Teamwork::project($projectId)->tasklists()['tasklists'];
                foreach ($tasklists as $tasklist) {
                    $tasklistId = (int) $tasklist['id'];
                    $tasklistName = $this->getTasklistName($tasklist['name']);

                    $tasklistsArray[$projectId]['tasklists'][] = [
                        'id' => $tasklistId,
                        'name' => $tasklistName,
                        'budget' => $this->getTasklistbudget($tasklist['name']),
                        'used' => (float) Teamwork::tasklist((int) $tasklist['id'])->timeTotal()['projects'][0]['tasklist']['time-totals']['total-hours-sum']
                    ];
                }

                $this->output->progressAdvance();
            }
            $i++;
        }

        $this->saveReport(array_values($tasklistsArray));

        $this->output->progressFinish();
    }

    /**
     * Separate the name from the tasklist.
     *
     * @return string $name
     */
    protected function getTasklistName($tasklist)
    {
        $name = $tasklist;
        $parenthesisPosition = strpos($name, '(');
        if ($parenthesisPosition) {
            $name = substr($tasklist, 0, $parenthesisPosition);
        }
        $name = trim($name);

        return $name;
    }

    /**
     * Separate the budget from the tasklist.
     *
     * @return int|false
     */
    protected function getTasklistBudget($tasklist)
    {
        strtok($tasklist, '(');
        $budget = strtok(')');

        return $this->formatBudget($budget);
    }

    /**
     * Read the budget budget and convert it into a single format.
     *
     * @param $budget
     * @return float $budget
     */
    protected function formatBudget($budget)
    {
        $budget = strtolower($budget);
        $budget = preg_replace('/(hours|hour|hrs|hr|h)/', '', $budget);
        $budget = trim($budget);

        return (float) $budget;
    }

    /**
     * Write report to JSON files.
     *
     * @param $report
     */
    protected function saveReport($report)
    {
        $time = time();

        if (Storage::exists('report.json')) {
            Storage::delete('report.json');
        }

        Storage::append('report-' . $time . '.json', json_encode($report, JSON_UNESCAPED_SLASHES));

        if (env('APP_DEBUG')) {
            Storage::append('report.json', json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } else {
            Storage::append('report.json', json_encode($report, JSON_UNESCAPED_SLASHES));
        }
    }
}
