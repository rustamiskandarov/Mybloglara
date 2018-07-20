<?php

namespace App\Http\Controllers;

use App\Mail\SubscibeEmail;
use App\Subscription;
use Illuminate\Http\Request;
use Mail;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:subscriptions'
        ]);

        $subs = Subscription::add($request->get('email'));
        $subs->generateToken();
        Mail::to($subs)->send(new SubscibeEmail($subs));
        return redirect()->back()->with('status', 'Проверьте вашу почту');
   }

    public function verify($token)
    {
        $subs = Subscription::where('token', $token)->firstOrFail(); //проверка если в базе токен совпадает с токеном из адресной строки то дольше иначе 404

        $subs->token = null; //стираем token в БД
        $subs->save();

        return redirect('/')->with('status', 'Ваша почта потверждена, спасибо');
   }
}
