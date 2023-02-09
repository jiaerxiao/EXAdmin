<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /public function login(Request $request)
    {
        Validator::make($request->input(), [
            "email" => 'required|email|exists:users',
            "password" => 'required|min:4',
            "captcha" => 'required|captcha'
        ], ['captcha.captcha' => '验证码输入错误'])->validate();

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::guard('web')->login($user);
            return $this->success('登录成功');
        }

        throw ValidationException::withMessages(['password' => '密码输入错误']);
    }

    public function register(Request $request, User $user)
    {
        Validator::make($request->input(), [
            'mobile' => ['required', Rule::unique('users')],
            'password' => ['required', 'confirmed'],
            'code' => ['required', new CodeRule()]
        ])->validate();

        $user->fill($request->input());
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->success('登录成功');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function password(Request $request)
    {
        $request->validate([
            'mobile' => ['required', Rule::exists('users', 'mobile')],
            'code' => ['required', new CodeRule()],
            'password' => ['required', 'confirmed'],
        ]);
        $user = User::whereMobile($request->mobile)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::guard('web')->login($user);
        return $this->success('密码重置成功');
    }
}
