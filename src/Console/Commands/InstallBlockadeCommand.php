<?php

namespace romanzipp\Blockade\Console\Commands;

use Illuminate\Console\Command;
use romanzipp\Blockade\Providers\BlockadeServiceProvider;

class InstallBlockadeCommand extends Command
{
    protected $signature = 'blockade:install {--update : Run on package update} {--views : Publish views} {--lang : Publish language files}';

    public function handle(): void
    {
        $tags = ['public', 'config'];

        if ($this->option('views')) {
            $tags[] = 'views';
        }

        if ($this->option('lang')) {
            $tags[] = 'lang';
        }

        $this->call('vendor:publish', [
            '--provider' => BlockadeServiceProvider::class,
            '--tag' => $tags,
            '--force' => $this->option('update'),
        ]);

        $this->info('[Laravel-Blockade] Publishing complete.');
    }
}
