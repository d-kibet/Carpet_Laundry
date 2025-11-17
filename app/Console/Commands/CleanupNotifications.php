<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupNotifications extends Command
{
    protected $signature = 'notifications:cleanup
                            {--days=30 : Delete notifications older than this many days}
                            {--keep-unread : Keep unread notifications}
                            {--dry-run : Run in dry-run mode without deleting}';

    protected $description = 'Clean up old notifications to improve performance';

    public function handle()
    {
        $days = $this->option('days');
        $keepUnread = $this->option('keep-unread');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No data will be deleted');
        }

        $this->info("Cleaning up notifications older than {$days} days...");
        $this->newLine();

        // Get total count before cleanup
        $totalBefore = DB::table('notifications')->count();
        $this->info("Total notifications before cleanup: {$totalBefore}");
        $this->newLine();

        $cutoffDate = now()->subDays($days);

        // Build query
        $query = DB::table('notifications')
            ->where('created_at', '<', $cutoffDate);

        if ($keepUnread) {
            $query->whereNotNull('read_at');
            $this->info('Keeping unread notifications...');
        }

        // Get count of notifications to delete
        $toDeleteCount = $query->count();

        if ($toDeleteCount === 0) {
            $this->info('✓ No notifications to clean up');
            return 0;
        }

        $this->warn("Found {$toDeleteCount} notifications to delete");

        if (!$dryRun) {
            if (!$this->confirm('Do you want to proceed with deletion?', true)) {
                $this->info('Cleanup cancelled');
                return 0;
            }

            $this->info('Deleting notifications...');
            $deleted = $query->delete();

            $totalAfter = DB::table('notifications')->count();

            $this->newLine();
            $this->info("✓ Deleted {$deleted} notifications");
            $this->info("Total notifications after cleanup: {$totalAfter}");
            $this->info("Space saved: " . ($totalBefore - $totalAfter) . " records");
        } else {
            $this->info("Would delete {$toDeleteCount} notifications");
        }

        $this->newLine();
        $this->info('✓ Cleanup completed!');

        return 0;
    }
}
