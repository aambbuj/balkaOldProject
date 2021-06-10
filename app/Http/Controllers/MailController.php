<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BulkaMail;
use App\Http\Traits\PikerrTraits;

class MailController extends Controller
{
    use PikerrTraits;
    public function sendMail(Request $request)
    {

       // echo $this->checkPinCode('779777');
        $details = [
            'title' => 'this is the test send mail',
            'body' => 'Success',
        ];

        Mail::to("ambujchand85@gmail.com")->send(new BulkaMail($details));
        return 'send mail success';
    }
}
