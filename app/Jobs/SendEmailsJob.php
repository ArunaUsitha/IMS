<?php

namespace App\Jobs;

use App\Mail\SendPurchaseOrderEmail;
use App\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $purchase_order_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($purchase_order_id)
    {
        $this->purchase_order_id = $purchase_order_id;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $supplierDetails = PurchaseOrder::getSupplierDetailByPurchaseOrderID($this->purchase_order_id);

        \Log::info($supplierDetails);

        $email = new SendPurchaseOrderEmail($this->purchase_order_id);
        Mail::to($supplierDetails->email)->send($email);
    }
}
