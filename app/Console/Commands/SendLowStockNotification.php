<?php

namespace App\Console\Commands;

use App\Stock;
use Illuminate\Console\Command;

class SendLowStockNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendLowStockNotification';

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

        $lowStockProducts = Stock::getLowStockProducts();

        \Log::info($lowStockProducts);


        if (!empty($lowStockProducts)) {
            foreach ($lowStockProducts as $lowStockProduct) {

                \Log::info('sending low stock notification');
                event(new \App\Events\SendLowStockNotification('Low stock on product code : ' . $lowStockProduct->code));

            }
        }


    }
}
