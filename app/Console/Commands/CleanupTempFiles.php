<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupTempFiles extends Command
{
    protected $signature = 'temp:cleanup';
    protected $description = 'Delete all temp files older than 1 days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $files = Storage::files('temp');
        foreach ($files as $file) {
            if (Storage::lastModified($file) < now()->subDay()->timestamp) {
                Storage::delete($file);
            }
        }
    }
}
