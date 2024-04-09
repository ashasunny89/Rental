<?php
   
namespace App\Console\Commands;
   
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
   
class unaCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'una:cron';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
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
     * @return mixed
     */
    public function handle()
    {
        

        $expiredRows = DB::table('user_profile')
        ->where('expiry_date', '<', Carbon::now())
        ->get();
        
        foreach ($expiredRows as $row) {
        DB::table('user_profile')
        ->where('id', $row->id)
        ->update(['expiry_date' => NULL]);
        }

    }
}