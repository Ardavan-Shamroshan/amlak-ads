<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Services\MailService;
use App\User;
use System\Session\Session;

class ForgotController {
    private $redirectTo = '/home';

    public function view() {
        return view('auth.forgot');
    }

    public function forgot() {
        if (Session::get('forgot.time') != false and Session::get('forgot.time') > time())
            error('forgot', 'please try 2 min later');
        Session::set('forgot.time', time() + 120);
        $request = new ForgotRequest();
        $inputs = $request->all();
        $user = User::where('email', $inputs['email'])->get();
        if (empty($user)) {
            error('کاربر وجود ندارد');
            return back();
        }
        $user = $user[0];
        $user->remember_token = generateToken();
        $user->remember_token_expire = date('Y_m_d H:i:s', strtotime(' + 10min'));
        $user->save();
        $message = '<h2>ایمیل بایابی رمز عبور</h2>
            <p>کاربر گرامی برای بازیابی رمز عبور خود از لینک زیر استفاده کنید.</p>
            <br>    
            <p style="text-align: center">
            <a href="' . route('auth.reset-password.view', [$user->remember_token]) . '">
            بازیابی رمز عبور
            </a>
            </p>';
        $mailService = new MailService();
        $mailService->send($inputs['email'], 'ایمیل بازیابی رمز عبور', $message);
        flash('forgot', 'ایمیل بازیابی با موفقیت ازسال شد');
        return redirect($this->redirectTo);
    }
}