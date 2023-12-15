<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyOrderBackup extends Command
{
    protected $signature = 'backup:orders';
    protected $description = 'Make a daily backup of orders';

    public function handle()
    {
        $backupDate = Carbon::now()->format('Y-m-d');
        $backupFileName = "orders_backup_{$backupDate}.sql";

        $tableName = 'orders';

        // Utiliza el comando mysqldump para hacer la copia de seguridad
        $command = sprintf(
            'mysqldump -u %s -p%s %s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $tableName,
            storage_path("app/backups/{$backupFileName}")
        );

        // Ejecuta el comando
        exec($command);

        $this->info("Backup completed and saved as {$backupFileName}");
    }
}
