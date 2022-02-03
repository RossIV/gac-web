<?php

namespace App\Http\Controllers;

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
        User::whereEmail($data['email'])->first()->sendLoginLink();
        session()->flash('success', true);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $token
     * @return RedirectResponse
     */
    public function verifyLogin(Request $request, $token): RedirectResponse
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();
        abort_unless($request->hasValidSignature() && $token->isValid(), 401);
        $token->consume();
        Auth::login($token->user);
        return redirect('/');
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
