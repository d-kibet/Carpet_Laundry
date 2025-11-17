<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanupDuplicateOverdueNotifications extends Command
{
    protected $signature = 'notifications:cleanup-duplicates
                            {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'One-time cleanup: Remove duplicate overdue delivery notifications';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No data will be deleted');
        } else {
            $this->warn('This will DELETE duplicate notifications from the database!');
            if (!$this->confirm('Are you sure you want to proceed?')) {
                $this->info('Operation cancelled.');
                return;
            }
        }

        $this->info('Starting cleanup of duplicate overdue notifications...');
        $startTime = microtime(true);

        // Get total count before cleanup
        $totalBefore = DB::table('notifications')
            ->where('type', 'App\Notifications\OverdueDeliveryNotification')
            ->count();

        $this->info("Total overdue notifications before cleanup: {$totalBefore}");

        // Strategy 1: Delete notifications for items that are already delivered
        $this->info("\n[1/3] Removing notifications for delivered items...");
        $deliveredCarpetNotifications = $this->cleanupDeliveredItems('carpet', $isDryRun);
        $deliveredLaundryNotifications = $this->cleanupDeliveredItems('laundry', $isDryRun);

        $deliveredTotal = $deliveredCarpetNotifications + $deliveredLaundryNotifications;
        $this->info("  → Notifications for delivered items: {$deliveredTotal}");

        // Strategy 2: For items still not delivered, keep only the most recent notification per item
        $this->info("\n[2/3] Removing duplicate notifications for overdue items (keeping most recent)...");
        $carpetDuplicates = $this->removeDuplicatesKeepLatest('carpet', $isDryRun);
        $laundryDuplicates = $this->removeDuplicatesKeepLatest('laundry', $isDryRun);

        $duplicatesTotal = $carpetDuplicates + $laundryDuplicates;
        $this->info("  → Duplicate notifications removed: {$duplicatesTotal}");

        // Strategy 3: Remove any orphaned notifications (item doesn't exist anymore)
        $this->info("\n[3/3] Removing orphaned notifications...");
        $orphaned = $this->removeOrphanedNotifications($isDryRun);
        $this->info("  → Orphaned notifications removed: {$orphaned}");

        // Get total count after cleanup
        if (!$isDryRun) {
            $totalAfter = DB::table('notifications')
                ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                ->count();

            $totalDeleted = $totalBefore - $totalAfter;
            $percentReduced = $totalBefore > 0 ? round(($totalDeleted / $totalBefore) * 100, 2) : 0;

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            // Summary table
            $this->info("\n" . str_repeat('=', 60));
            $this->info('CLEANUP SUMMARY');
            $this->info(str_repeat('=', 60));

            $this->table(
                ['Category', 'Count'],
                [
                    ['Notifications before cleanup', number_format($totalBefore)],
                    ['Delivered items', number_format($deliveredTotal)],
                    ['Duplicates', number_format($duplicatesTotal)],
                    ['Orphaned', number_format($orphaned)],
                    ['Total deleted', number_format($totalDeleted)],
                    ['Notifications after cleanup', number_format($totalAfter)],
                    ['Reduction', "{$percentReduced}%"],
                    ['Execution time', "{$duration}s"],
                ]
            );

            $this->info("\n✅ Cleanup completed successfully!");
        } else {
            $this->warn("\nDRY RUN completed. No data was deleted.");
            $this->info("Run without --dry-run to actually delete the notifications.");
        }
    }

    private function cleanupDeliveredItems($type, $isDryRun)
    {
        $modelClass = $type === 'carpet' ? 'App\Models\Carpet' : 'App\Models\Laundry';

        // Get IDs of delivered items
        $deliveredIds = DB::table($type === 'carpet' ? 'carpets' : 'laundries')
            ->where('delivered', 'Delivered')
            ->pluck('id')
            ->toArray();

        if (empty($deliveredIds)) {
            return 0;
        }

        // Count notifications to be deleted
        $count = DB::table('notifications')
            ->where('type', 'App\Notifications\OverdueDeliveryNotification')
            ->where('data->service_type', $type)
            ->whereIn('data->service_id', $deliveredIds)
            ->count();

        if (!$isDryRun && $count > 0) {
            DB::table('notifications')
                ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                ->where('data->service_type', $type)
                ->whereIn('data->service_id', $deliveredIds)
                ->delete();
        }

        return $count;
    }

    private function removeDuplicatesKeepLatest($type, $isDryRun)
    {
        // Get all unique service IDs that have overdue notifications
        $serviceIds = DB::table('notifications')
            ->where('type', 'App\Notifications\OverdueDeliveryNotification')
            ->where('data->service_type', $type)
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id")) as service_id'))
            ->distinct()
            ->pluck('service_id')
            ->toArray();

        $totalDeleted = 0;

        foreach ($serviceIds as $serviceId) {
            // Get all notification IDs for this service, ordered by created_at DESC
            $notificationIds = DB::table('notifications')
                ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                ->where('data->service_type', $type)
                ->where('data->service_id', $serviceId)
                ->orderBy('created_at', 'desc')
                ->pluck('id')
                ->toArray();

            // Keep the first (most recent), delete the rest
            if (count($notificationIds) > 1) {
                $toDelete = array_slice($notificationIds, 1); // Skip first, take rest

                if (!$isDryRun) {
                    DB::table('notifications')->whereIn('id', $toDelete)->delete();
                }

                $totalDeleted += count($toDelete);
            }
        }

        return $totalDeleted;
    }

    private function removeOrphanedNotifications($isDryRun)
    {
        // Get all carpet IDs from notifications
        $carpetNotificationIds = DB::table('notifications')
            ->where('type', 'App\Notifications\OverdueDeliveryNotification')
            ->where('data->service_type', 'carpet')
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id")) as service_id'))
            ->distinct()
            ->pluck('service_id')
            ->toArray();

        // Get existing carpet IDs
        $existingCarpetIds = DB::table('carpets')->pluck('id')->toArray();

        // Find orphaned carpet IDs
        $orphanedCarpetIds = array_diff($carpetNotificationIds, $existingCarpetIds);

        $carpetOrphaned = 0;
        if (!empty($orphanedCarpetIds)) {
            $carpetOrphaned = DB::table('notifications')
                ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                ->where('data->service_type', 'carpet')
                ->whereIn(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id"))'), $orphanedCarpetIds)
                ->count();

            if (!$isDryRun && $carpetOrphaned > 0) {
                DB::table('notifications')
                    ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                    ->where('data->service_type', 'carpet')
                    ->whereIn(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id"))'), $orphanedCarpetIds)
                    ->delete();
            }
        }

        // Same for laundry
        $laundryNotificationIds = DB::table('notifications')
            ->where('type', 'App\Notifications\OverdueDeliveryNotification')
            ->where('data->service_type', 'laundry')
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id")) as service_id'))
            ->distinct()
            ->pluck('service_id')
            ->toArray();

        $existingLaundryIds = DB::table('laundries')->pluck('id')->toArray();
        $orphanedLaundryIds = array_diff($laundryNotificationIds, $existingLaundryIds);

        $laundryOrphaned = 0;
        if (!empty($orphanedLaundryIds)) {
            $laundryOrphaned = DB::table('notifications')
                ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                ->where('data->service_type', 'laundry')
                ->whereIn(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id"))'), $orphanedLaundryIds)
                ->count();

            if (!$isDryRun && $laundryOrphaned > 0) {
                DB::table('notifications')
                    ->where('type', 'App\Notifications\OverdueDeliveryNotification')
                    ->where('data->service_type', 'laundry')
                    ->whereIn(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(data, "$.service_id"))'), $orphanedLaundryIds)
                    ->delete();
            }
        }

        return $carpetOrphaned + $laundryOrphaned;
    }
}
