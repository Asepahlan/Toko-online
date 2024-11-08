<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearImageCache extends Command
{
    protected $signature = 'cache:images:clear';
    protected $description = 'Clear cached images';

    public function handle()
    {
        Cache::tags(['images'])->flush();
        $this->info('Image cache cleared successfully.');
    }
}
