<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:create {name? : The name of the database}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = $this->argument('name') ?? config('database.connections.mysql.database');

        if (!$databaseName) {
            $this->error('No database name provided!');
            return 1;
        }

        try {
            $originalDatabase = Config::get('database.connections.mysql.database');

            Config::set('database.connections.mysql.database', null);
            DB::purge('mysql');
            DB::reconnect('mysql');

            DB::statement("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $this->info("Database '{$databaseName}' created successfully!");

            Config::set('database.connections.mysql.database', $originalDatabase);
            DB::purge('mysql');
            DB::reconnect('mysql');

            return 0;

        } catch (\Exception $e) {
            $this->error("Failed to create database: " . $e->getMessage());
            return 1;
        }
    }
}
