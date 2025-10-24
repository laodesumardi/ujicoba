<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\StorageHelper;

class SyncStorageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:sync {--force : Force sync even if files exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync storage files to public/storage for hosting compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting storage sync...');
        
        $force = $this->option('force');
        
        if (!$force && is_dir(public_path('storage'))) {
            if (!$this->confirm('Public storage directory already exists. Continue?')) {
                $this->info('❌ Sync cancelled.');
                return;
            }
        }
        
        $this->info('📁 Syncing files from storage/app/public to public/storage...');
        
        $results = StorageHelper::syncToPublic();
        
        $this->info("✅ Successfully synced: {$results['success']} items");
        
        if ($results['failed'] > 0) {
            $this->error("❌ Failed to sync: {$results['failed']} items");
            
            if (!empty($results['errors'])) {
                $this->error('Errors:');
                foreach ($results['errors'] as $error) {
                    $this->error("  - $error");
                }
            }
        }
        
        $this->info('🎉 Storage sync completed!');
        $this->info('💡 Your images should now be accessible via /storage/... URLs');
    }
}
