# TeamReport

- [Architecture](#architecture)
- [First Time Installation](#first-time-installation)
- [Generating Reports](#generating-reports)
- [Development How-To](#development)

<a name="architecture"></a>
## Architecture

### GenerateReports

`GenerateReports` is a PHP class in `app/Console/Command` that handles the business logic of pulling data from the TeamWork API and converting our (awkwardly specific) tasklist naming conventions into usable budget data. It's entry point is the `handle()` method and can be run from Laravel's Artisan CLI:

`php artisan reports:generate`

There is another `GenerateReports` class in the `app/Jobs` directory. This acts as a sort of proxy that calls Artisan and runs the `reports:generate` command. [<sup>1</sup>](#footnote-1)

Then in `ReportsController` (`app/Http/Controllers`) there is a `generate()` method which is available at the `example.com/generate` route, which simply dispatches that Job.

So it's a bit of a journey: Click hyperlink -> Route sends you to -> Controller method which dispatches a -> Job which runs -> an Artisan Command.

Simple.

<a name="footnote-1"></a>
1. This is because Artisan isn't available at the Controller layer.

### API

### Single Page Application

<a name="first-time-installation"></a>
## First Time Installation

1. `git pull`
1. `composer install`
1. `npm install`

<a name="generating-reports"></a>
## Generating Reports

TeamReport uses the TeamWork API to gather and compile data into a single report file `storage/app/report.json`. The code that does this is located in `app/Console/Commands/GenerateReports.php`.

### With a button

The report can be generated manually with a button in the header, and a new report will be queued up and generated in the background, with the previous one being stored in a file with the timestamp appended, ie. `report-663552000.json`. This means we keep a complete history of previous reports in the filesystem. Note that there is currently no indication of when the job is complete.

### With the CLI

`php artisan reports:generate`

Laravel's Artisan command line interface, among many other things, can run commands, which like `GenerateReports` are PHP classes that extend `Illuminate\Console\Command`. The entry point is the `handle()` method.

You can pass the `--queue` option to add it to the queue to be processed immediately, or you can run it synchronously and you will see a progress bar showing how many projects have been completed.

```bash
-sh-4.2$ php artisan reports:generate
Downloading projects from Teamwork:
  5/51 [==>-------------------------]   9%
```

### Automatically on a schedule

You probably want this to be done automatically every day. This requires a queue system (so does the button approach, so this is required regardless), and luckily Laravel has a robust application-defined queue that can schedule and run tasks, with a simple heartbeat cronjob to trigger it. Below is one of a few ways to go about setting this up. You'll need a database to store the queued tasks, a daemon running to add new tasks to the queue and a crontab entry hitting `artisan` regularly to check for queued jobs.

1. Create a database.
    `touch storage/database.sqlite`

1. Run the migrations to create the necessary tables for the jobs.
    `php artisan migrate`

1. Start up the queue listener daemon.
    `php artisan queue:work --daemon`.
    This will look for queued tasks in the database table and run them. Contact your friendly sysadmin for help making sure this runs on system startup.

1. Create a cronjob that runs Artisan. It can be set to however often you think suitable, but the convention is every minute. If no tasks are queued it will return 

<a name="development"></a>
## Development How-To

1. **Optional:** `gulp` to fire up BrowserSync.
1. `gulp watch` to watch files for changes.

It is recommend to add `&` to the end of commands to run them in the background.