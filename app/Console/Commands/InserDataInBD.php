<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\AmountCollection;
use Carbon\Carbon;

class InserDataInBD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inser_data';

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
     * @return int
     */
    public function handle()
    {
        for($i = 1; $i < 91; $i++){
            for($j = 1; $j < 30; $j++){
                $data = Carbon::parse('2024-01-23')->subDay($j)->format('Y-m-d');
                $amount = new AmountCollection;
                $amount->user_id = $i;
                $amount->date = $data;
                $amount->amount = $j;
                $amount->save();
            }
        }   
    }
}
