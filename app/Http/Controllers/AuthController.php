<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' =>'required',
            'email' =>'required|email|unique:users',
            'password' => 'required'
        ]);

       $user = User::add($request->all());
       $user->generatePassword($request->get('password'));

       return redirect('/login');
    }

    public function loginForm()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' =>'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt([  //если попытка сравнить емаил и пароль из формы с данными из бд и ваторизоваться прошла успешно
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]))
        {
            return redirect('/'); //то возвращаемся на главную странницу
        }
        return redirect()->back()->with('status', 'Неправильный логин или пароль'); // иначе возращаемся на предыдущую страницу и выводим ошибку
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
