<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\StoreReport;

class WeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:WeeklyReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Weekly Report';

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
        //
        $saveReportW=new StoreReport([
            "ReportName"=>"test",
            "ReportType"=>"Weekly",
            "ReportOrders"=>serialize([1,2,3,4]),
            "ReportStoreId"=>"29",
        ]);
        $saveReportW->save();
    }
}
