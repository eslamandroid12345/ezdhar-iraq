<?php

namespace App\Console\Commands;

use App\Models\ServiceRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddWalletProvider extends Command
{

    protected $signature = 'wallet:add';

    protected $description = 'update wallet of provider every week with service request';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $serviceRequests = ServiceRequest::whereDay('created_at','=',Carbon::now()->addDays(6)->format('d'))->where('status','=','accepted')->get();


        foreach ($serviceRequests as $serviceRequest){

            $provider = User::where('id','=',$serviceRequest->id)->first();

           $provider->update([

                'wallet' => $provider->wallet+=$serviceRequest->price

            ]);
        }
    }
}
