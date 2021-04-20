<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\carbon;

use App\StoreReport;
use App\Stores;
use App\StoreOrder;


class MonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:MonthlyReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Monthly Report';

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
    //get All By Stores
    $Stores=Stores::all();

    foreach ($Stores as $store) {

    //get Orders
    $StoreOrderM=StoreOrder::where("OrderStoreId",$store['id'])->WhereMonth("created_at",carbon::now()->month)->get();

    $OrderIdArr=array();
    foreach ($StoreOrderM as $orders ) {
        array_push($OrderIdArr,$orders['id']);
    }
    //Save Monthly Report
    $saveReportM=new StoreReport([
        "ReportName"=>"test",
        "ReportType"=>"Monthly",
        "ReportOrders"=>serialize($OrderIdArr),
        "ReportStoreId"=>$store['id'],
    ]);
    $saveReportM->save();
    }
  }
}
