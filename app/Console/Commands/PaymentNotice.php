<?php

namespace App\Console\Commands;

use App\Payment;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class PaymentNotice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:notice';

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
        $i = 0;
        while ($i<100) {
            $payment = Payment::where('status',0) ->orderBy('created_at', 'ASC')->first();
            if ($payment) {
                if (Payment::where('id', $payment->id)
                    ->where('status', 0)
                    ->update(['status' => 1])){
                    $tmp = explode('---',$payment->order_id);
                    if (strstr($tmp[1],'mypic')) {
                        $url ="http://www.mypic.life";
                    }else{
                        $url ="http://real.diandi.org";
                    }
                    $url.="/api/callback/payment/".$tmp[0];
                    $client = new Client();
                    $res = $client->request('GET', $url, [
                        'auth' => ['user', 'pass']
                    ]);
                    $payment->response = json_encode($res->getBody()->getContents());
                    $payment->status=2;
                    $payment->save();
                }
            }
            sleep(1);
        }

    }
}
