<?php


namespace Modules\FinalizeEarly\Main;


use App\Exceptions\RequestException;
use App\Marketplace\ModuleManager;
use App\Purchase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Procedure
{
    public function commandHandle($command){
        $command->info(Purchase::where(function($query){
            $query->where('state', 'sent');
            $query->where('type', 'fe');
        })->orWhere(function($query){
            $query->where('state', 'purchased');
            $query->where('type', 'fe');
        })->toSql());
        // select all in this state with finalize early
        $purchasedPurchases = Purchase::where(function($query){
            $query->where('state', 'sent');
            $query->where('type', 'fe');
        })->orWhere(function($query){
            $query->where('state', 'purchased');
            $query->where('type', 'fe');
        })->get();
        $command->info("There is  Finalize Early " . $purchasedPurchases->count() . " unresolved purchases!");

        // foreach purchase
        foreach ($purchasedPurchases as $purchase){

            // identify purchase in console
            $command->info("Purchase $purchase->short_id : \n");

            // check if there is enough  balance
            if($purchase->enoughBalance()){
                try{
                    // Complete them if there are
                    $purchase->complete();
                    $command->info("This purchase is completed!");
                }
                catch (RequestException $exception){
                    $purchase->status_notification  = $exception->getMessage();
                    $purchase->save();
                    $command->error("We are unable to complete this purchase, please check the log for details!");
                    Log::error($exception);
                }
            }else{
                $command->warn("There is not enough balance on this purchase!");
            }
        }

        $command->info( 'There is ' . Purchase::where('state', 'purchased')->where('type', 'fe')->count() . ' Finalize Early unresolved purchases waiting for funds!');
    }



}