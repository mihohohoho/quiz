<?php

namespace App\Http\Controllers;
use App\User;
use Socialite;
use App\Http\Controllers\QuizController;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('User.index')->with(['own_quizzes' => $user->getOwnPaginateByLimit()]);
    }
    
    // Googleの認証ページへのリダイレクト処理
    public function getGoogleAuth($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Googleの認証情報からユーザー情報の取得
    public function authGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::firstOrNew(['email' => $googleUser->email]);

        if (!$user->exists) {
            $user['name'] = $googleUser->getNickName() ?? $googleUser->getName() ?? $googleUser->getNick();
            $user['email'] = $googleUser->email; // Gmailアドレス
            $user['password'] = str_random(); // 適当に生成

            $user->save();
        }

        Auth::login($user);
        return redirect()->route('/');
    }
    
}