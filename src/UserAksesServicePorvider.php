<?php

namespace BangLipai\UserAkses;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class UserAksesServicePorvider extends ServiceProvider
{
    public function boot()
    {
        $this->offerPublishing();
    }

    public function register()
    {
        //
    }

    protected function offerPublishing(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../database/migrations/create_grup_akses_table.php.stub'   => $this->getMigrationFileName('create_grup_akses_table.php'),
            __DIR__ . '/../database/migrations/create_grup_anggota_table.php.stub' => $this->getMigrationFileName('create_grup_anggota_table.php'),
            __DIR__ . '/../database/migrations/create_m_akses_table.php.stub'      => $this->getMigrationFileName('create_m_akses_table.php'),
            __DIR__ . '/../database/migrations/create_m_grup_table.php.stub'       => $this->getMigrationFileName('create_m_grup_table.php'),
            __DIR__ . '/../database/migrations/create_route_akses_table.php.stub'  => $this->getMigrationFileName('create_route_akses_table.php'),
            __DIR__ . '/../database/migrations/create_route_table.php.stub'        => $this->getMigrationFileName('create_route_table.php'),
            __DIR__ . '/../database/migrations/create_user_akses_table.php.stub'   => $this->getMigrationFileName('create_user_akses_table.php'),
            __DIR__ . '/../database/migrations/create_user_grup_table.php.stub'    => $this->getMigrationFileName('create_user_grup_table.php'),

            __DIR__ . '/../database/migrations/add_foreign_keys_to_grup_akses_table.php.stub'   => $this->getMigrationFileName('add_foreign_keys_to_grup_akses_table.php'),
            __DIR__ . '/../database/migrations/add_foreign_keys_to_grup_anggota_table.php.stub' => $this->getMigrationFileName('add_foreign_keys_to_grup_anggota_table.php'),
            __DIR__ . '/../database/migrations/add_foreign_keys_to_route_akses_table.php.stub'  => $this->getMigrationFileName('add_foreign_keys_to_route_akses_table.php'),
            __DIR__ . '/../database/migrations/add_foreign_keys_to_user_akses_table.php.stub'   => $this->getMigrationFileName('add_foreign_keys_to_user_akses_table.php'),
            __DIR__ . '/../database/migrations/add_foreign_keys_to_user_grup_table.php.stub'    => $this->getMigrationFileName('add_foreign_keys_to_user_grup_table.php'),

        ], 'permission-migrations');
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(string $migrationFileName): string
    {
        $timestamp = date('2023_12_29_000000');
        if (Str::contains($migrationFileName, 'add')) {
            $timestamp = date('2023_12_29_000001');
        }

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make([$this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR])
            ->flatMap(fn($path) => $filesystem->glob($path . '*_' . $migrationFileName))
            ->push($this->app->databasePath() . "/migrations/{$timestamp}_$migrationFileName")
            ->first();
    }
}