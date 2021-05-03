<?php

namespace App\Mail;

use App\PurchaseOrder;
use App\SystemDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendPurchaseOrderEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $purchase_order_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($purchase_order_id)
    {
        $this->purchase_order_id = $purchase_order_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $company_name = SystemDetail::where('key', 'company_name')->select('value')->first();
        $company_address = SystemDetail::where('key', 'company_address')->select('value')->first();
        $company_phone = SystemDetail::where('key', 'company_phone')->select('value')->first();
        $companyName = $company_name->value;
        $companyAddress = $company_address->value;
        $companyPhone = $company_phone->value;


        //build email with data
       $details = PurchaseOrder::getPurchaseOrderDetailsByID($this->purchase_order_id);

        $data = array(
            'header_details' => array(
                'company_name' => $companyName,
                'company_address' => $companyAddress,
                'company_phone' => $companyPhone
            ),
            'details' => $details,
        );


        return $this->subject('New Purchase order request')
            ->view('email.purchase_order')->with('data', $data);
    }
}
