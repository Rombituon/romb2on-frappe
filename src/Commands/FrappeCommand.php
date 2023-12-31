<?php

namespace Romb2on\Frappe\Commands;

use Illuminate\Console\Command;

class FrappeCommand extends Command
{
    public $signature = 'romb2on-frappe';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
