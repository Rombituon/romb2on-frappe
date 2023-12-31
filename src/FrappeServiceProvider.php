<?php

namespace Romb2on\Frappe;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Romb2on\Frappe\Commands\FrappeCommand;

class FrappeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('romb2on-frappe')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_romb2on-frappe_table')
            ->hasCommand(FrappeCommand::class);
    }
}
