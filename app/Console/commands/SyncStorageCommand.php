<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncStorageCommand extends Command
{
    protected $signature = 'storage:sync-public';
    protected $description = 'Copy storage/app/public to the subdomain public storage folder';

    public function handle()
    {
        $source = storage_path('app/public');
        $destination = base_path('../admin.torchbearer.co.ke/storage');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        File::copyDirectory($source, $destination);

        $this->info('✅ Storage synced successfully.');
    }
}
