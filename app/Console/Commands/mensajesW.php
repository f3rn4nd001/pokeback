<?php

namespace App\Console\Commands;
use Twilio\Rest\Client;
use Illuminate\Console\Command;
use DB;
class mensajesW extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:worl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        return 0;
    }
}
