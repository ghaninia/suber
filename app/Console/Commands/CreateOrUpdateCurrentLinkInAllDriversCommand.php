<?php

namespace App\Console\Commands;

use App\Kernel\Parser\Classes\Creator;
use Illuminate\Console\Command;

class CreateOrUpdateCurrentLinkInAllDriversCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all links to current drivers pages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new Creator)->links() ;

        $this->alert("Update all links to current drivers pages") ;

    }
}
