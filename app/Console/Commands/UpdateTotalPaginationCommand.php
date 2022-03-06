<?php

namespace App\Console\Commands;

use App\Kernel\Parser\Classes\Creator;
use Illuminate\Console\Command;

class UpdateTotalPaginationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:paginations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Paginations in all Drivers';

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
        (new Creator)->paginations() ;
        $this->alert("Update total paginations on all drivers") ;
    }
}
