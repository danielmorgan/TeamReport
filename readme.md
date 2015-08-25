# TeamReport

## Installation

1. `git pull`
1. `composer install`
1. `npm install`

## Set up queue

1. `touch storage/database.sqlite`
1. `php artisan migrate`
1. `php artisan queue:listen`

## Frontend development

1. **Optional:** `gulp` to fire up BrowserSync.
1. `gulp watch` to watch files for changes.

It is recommend to add `&` to the end of commands to run them in the background.
