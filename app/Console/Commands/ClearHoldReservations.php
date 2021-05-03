<?php

namespace App\Console\Commands;

use App\Reservation;
use Illuminate\Console\Command;

class ClearHoldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ClearHoldReservations';

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
        //select all hold jobs
        \Log::info('clearing hold reservations');

        $holdReservations = Reservation::where('status','hold')->get();
        $finishTime =  \Carbon\Carbon::now();



        foreach ($holdReservations as $holdReservation){
            $totalDuration = $finishTime->diffInSeconds($holdReservation->created_at);

            if ($totalDuration > 900){

                $reservation = Reservation::find($holdReservation->id);

                \Log::info($reservation->id .' has been mark as cancelled');
                $reservation->status = 'cancelled';
                $reservation->save();
            }
        }

    }
}
