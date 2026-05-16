<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupProduction extends Command
{
    protected $signature = 'app:setup-production';
    protected $description = 'Run all post-deploy setup steps for production';

    public function handle()
    {
        $this->info('🚀 Running production setup...');

        $this->call('migrate', ['--force' => true]);
        $this->call('db:seed', ['--force' => true]);
        $this->call('storage:link');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        $this->info('✅ Production setup complete!');
    }
}
