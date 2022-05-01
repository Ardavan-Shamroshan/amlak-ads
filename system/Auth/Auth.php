<?php

namespace System\Auth;

use App\User;
use System\Session\Session;

class Auth {
    private $redirectTo = "/login";

    /**
     * @return mixed
     */
    private function userMethod() {
        if (!Session::get('user'))
            return redirect($this->redirectTo);
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return redirect($this->redirectTo);
        } else
            return $user;
    }

    /**
     * @return bool|void
     */
    private function checkMethod() {
        if (!Session::get('user')) {
            return redirect($this->redirectTo);
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return redirect($this->redirectTo);
        } else
            return true;
    }

    /**
     * @return bool
     */
    private function checkLoginMethod() {
        if (!Session::get('user')) {
            return false;
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            return false;
        } else
            return true;
    }

    /**
     * Login by user email.
     *
     * @param $email
     * @param $password
     * @return bool
     */
    private function loginByEmailMethod($email, $password) {
        $user = User::where('email', $email)->get();
        if (empty($user)) {
            error('login', 'کاربر وجود ندارد');
            return false;
        }
        if (password_verify($password, $user[0]->password) && $user[0]->is_active == 1) {
            Session::set("user", $user[0]->id);
            return true;
        } else {
            error("login", 'کلمه ی عبور اشتباه است');
            return false;
        }
    }

    /**
     * Set session by user id.
     *
     * @param $id
     * @return bool
     */
    private function loginByIdMethod($id) {
        $user = User::find($id);
        if (empty($user)) {
            error("login", "کاربر وجود ندارد");
            return false;
        } else {
            Session::set("user", $user->id);
            return true;
        }
    }

    /**
     * Logout : unset session.
     */
    private function logoutMethod() {
        Session::remove('user');
    }

    /**
     * Call Methods.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        return $this->methodCaller($name, $arguments);
    }

    /**
     * Call methods in static.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments) {
        $instance = new self();
        return $instance->methodCaller($name, $arguments);
    }

    /**
     * Does the methods call operate.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    private function methodCaller($method, $arguments) {
        $suffix = 'Method';
        $methodName = $method . $suffix;
        return call_user_func_array(array($this, $methodName), $arguments);
    }
}