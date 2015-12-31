# TeamReport

- [Architecture](#architecture)
- [Generating Reports](#generating-reports)
- [First Time Installation](#first-time-installation)
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

There is a RESTful API that parses the report JSON file and can give you information filtered by project or tasklist.

`app/Http/routes.php` or `php artisan route:list` can tell you what methods are available.

### Single Page Application

The SPA is marked up in `resources/views` with blade templates, but most of the logic is in `resources/assets/js`. It's built with [Backbone](http://backbonejs.org/), the models interact with the REST API to pass the relevant report data to the views, which handle rendering the charts and such. [Chart.js](http://www.chartjs.org/) is used for the charts.

<a name="generating-reports"></a>
## Generating Reports

TeamReport uses the TeamWork API to gather and compile data into a single report file `storage/app/report.json`. The code that does this is located in `app/Console/Commands/GenerateReports.php`.

### With a button

The report can be generated manually with a button in the header, and a new report will be queued up and generated in the background, with the previous one being stored in a file with the timestamp appended, ie. `report-663552000.json`.

#### Setting up the Queue

You'll need a database to store the queued tasks, a daemon running to add new tasks to the queue and a crontab entry hitting `artisan` regularly to check for queued jobs.

1. Create a database.
    `touch storage/database.sqlite`

1. Run the migrations to create the necessary tables for the jobs.
    `php artisan migrate`

1. Start up the queue listener daemon.
    `php artisan queue:work --daemon`.
    This will look for queued tasks in the database table and run them.

### With the CLI

`php artisan reports:generate`

Laravel's Artisan command line interface, among many other things, can run commands, which like `GenerateReports` are PHP classes that extend `Illuminate\Console\Command`. The entry point is the `handle()` method.

You can pass the `--queue` option to add it to the queue to be processed, or you can run it synchronously and you will see a progress bar showing how many projects have been completed.

```bash
-sh-4.2$ php artisan reports:generate
Downloading projects from Teamwork:
  5/51 [==>-------------------------]   9%
```

### Scheduled

Create a cronjob that runs Artisan. It can be set to however often you think suitable, but the convention is every minute. If no tasks are queued it will return a message indicating so to stdout.

When the report is generated is defined in `app/console/Kernel.php`.

This means we keep a complete history of previous reports in the filesystem, so there's potential there for future features.

<a name="first-time-installation"></a>
## First Time Installation

1. `git pull`
1. `composer install`
1. `npm install`

<a name="development"></a>
## Development How-To

1. **Optional:** `gulp` to fire up BrowserSync.
1. `gulp watch` to watch files for changes.

It is recommend to add `&` to the end of commands to run them in the background.