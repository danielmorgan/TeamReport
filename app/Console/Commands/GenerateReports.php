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
        {--production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate reports based on tasklist titles fetched from TeamworkPM.';

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
        $this->comment('Downloading projects from Teamwork:');
        $this->generateReport();
    }

    /**
     * Fetch tasklists from TeamworkPM API and write to local files.
     */
    protected function generateReport()
    {
        $tasklistsArray = [];

        $projects = Teamwork::project()->all()['projects'];
        $this->output->progressStart(count($projects));

        foreach ($projects as $project) {
            $id = (int) $project['id'];
            $tasklistsArray[$project['name']] = [];
            $tasklistsArray[$project['name']]['id'] = $id;
            $tasklistsArray[$project['name']]['name'] = $project['name'];
            $tasklistsArray[$project['name']]['company'] = $project['company']['name'];

            $tasklists = Teamwork::project($id)->tasklists()['tasklists'];
            foreach ($tasklists as $tasklist) {
                $name = $this->getTasklistName($tasklist['name']);
                $tasklistsArray[$project['name']]['tasklists'][$name]['name'] = $name;
                $tasklistsArray[$project['name']]['tasklists'][$name]['id'] = $this->getTasklistbudget($tasklist['name']);
                $tasklistsArray[$project['name']]['tasklists'][$name]['budget'] = $this->getTasklistbudget($tasklist['name']);
                $tasklistsArray[$project['name']]['tasklists'][$name]['used'] = (float) Teamwork::tasklist((int) $tasklist['id'])->timeTotal()['projects'][0]['tasklist']['time-totals']['total-hours-sum'];
            }

            $this->output->progressAdvance();
        }

        $this->saveReport($tasklistsArray);

        $this->output->progressFinish();
    }

    /**
     * Seperate the name from the tasklist.
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
     * Seperate the budget from the tasklist.
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
     * @param float $budget
     */
    protected function formatBudget($budget)
    {
        $budget = strtolower($budget);
        $budget = preg_replace('/(hours|hour|hrs|hr|h)/', '', $budget);
        $budget = trim($budget);

        return (float) $budget;
    }

    protected function saveReport($report)
    {
        $time = time();

        if (Storage::exists('report.json')) {
            Storage::delete('report.json');
        }
        if (! env('APP_DEBUG') || $this->option('production')) {
            Storage::append('report.json', json_encode($report, JSON_UNESCAPED_SLASHES));
            Storage::append('report-' . $time . '.json', json_encode($report, JSON_UNESCAPED_SLASHES));
        } else {
            Storage::append('report.json', json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            Storage::append('report-' . $time . '.json', json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    }
}
