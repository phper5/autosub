<?php


namespace App\Api\Callback;


use App\Payment;
use Illuminate\Http\Request;

class AliController
{
    public function notice(Request $request) {
        $data =  $request->all();
        $payment = new Payment();
        $payment->data = json_encode($data);
        $payment->order_id = $data['subject'];
        $payment->amount = $data['invoice_amount'];
        $payment->platform = 'ali';
        $payment->save();
        return [
            'status'=>'ok'
        ];
    }
    public function sync(Request $request) {
        $data =  $request->all();
        $payment = new Payment();
        $payment->data = json_encode($data);
        $payment->order_id = $data['subject'];
        $payment->amount = $data['invoice_amount'];
        $payment->platform = 'ali';
        $payment->save();
        return [
            'status'=>'ok'
        ];
    }
}
