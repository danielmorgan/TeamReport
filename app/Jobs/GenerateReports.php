<?php

namespace TeamReport\Jobs;

use Teamwork;
use Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateReports extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->generateReport();
    }

    /**
     * Fetch tasklists from TeamworkPM API and write to local files.
     */
    protected function generateReport()
    {
        $tasklistsArray = [];

        $projects = Teamwork::project()->all()['projects'];
        foreach ($projects as $project) {
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
        }

        $this->saveReport(array_values($tasklistsArray));
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
        if (! env('APP_DEBUG')) {
            Storage::append('report.json', json_encode($report, JSON_UNESCAPED_SLASHES));
            Storage::append('report-' . $time . '.json', json_encode($report, JSON_UNESCAPED_SLASHES));
        } else {
            Storage::append('report.json', json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            Storage::append('report-' . $time . '.json', json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    }
}
