<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\StoreUser;

class DailyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change left days for registerd users';

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
      // PlanDayLeft-1
      $users=StoreUser::where([['UserStatus','!=','0'],['PlanType','!=','0'],['UserStatus','=','1'],['PlanDayLeft','>','0']])->get();
      foreach($users as $u){

          
          $usersUpdate=StoreUser::find($u['id'])->update(['PlanDayLeft'=>$u['PlanDayLeft']-1]);
          $this->info($u['PlanDayLeft']-1);
      }
      //

      //change user status to suspend if PlanDayLeft ==0
      $users2=StoreUser::where('PlanDayLeft','=','0')->update(['PlanType'=>'0']);
          $this->info($users2);
      
      //



    }
}
