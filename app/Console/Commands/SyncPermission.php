<?php

namespace App\Console\Commands;

use App\Services\Permission\PermissionService;
use Illuminate\Console\Command;

class SyncPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync permissions base on policies and extra permissions config';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        PermissionService::syncBaseOnPolicies();

        $this->info('Permissions synced successfully');
    }
}
