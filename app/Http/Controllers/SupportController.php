<?php


namespace App\Http\Controllers;


use App\Feedback;
use Illuminate\Http\Request;

class SupportController
{
    public function post(Request $request) {
        $feedback = new Feedback();
        $feedback->message=$request->input('message');
        $feedback->subject=$request->input('subject');
        $feedback->contact=$request->input('contact');
        $feedback->user_info=$request->input('user_info');
        $feedback->save();
        return redirect("support/sent");
    }
}
