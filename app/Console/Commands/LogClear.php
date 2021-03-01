<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LogClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Laravel log';

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
        // route
        $this->call('route:cache');

        // config
        $this->call('config:clear');

        // cache
        $this->call('cache:clear');

        // view
        $this->call('view:clear');

        // clockwork
        $this->deleteAll('clockwork');

        // debugbar
        $this->deleteAll('debugbar');

        // laravel
        $this->deleteAll('logs');

        // framework/cache
        $this->deleteAll('framework/cache/data');

        // framework/sessions
        $this->deleteAll('framework/sessions');
    }

    public function deleteAll($path)
    {
        if (!\File::exists(storage_path($path))) {
            $this->comment($path . ' not exist');
            return;
        }

        exec('rm ' . storage_path($path . '/*'));
    }
}
