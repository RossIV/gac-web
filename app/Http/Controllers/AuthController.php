<?php

namespace App\Http\Controllers;

use App\Models\Affiliation;
use App\Models\LoginToken;
use App\Models\User;
use Carbon\Carbon;
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
        $affiliations = Affiliation::get();
        return view('auth.login', ['affiliations' => $affiliations]);
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
        $user = User::whereEmail($data['email'])->first();
        $user->sendLoginLink();
        session()->flash('success', true);

        activity('auth')
            ->event('login')
            ->performedOn($user)
            ->withProperties([
                'ip' => $request->ip(),
            ])
            ->log('Magic Link Requested');

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

        if ($token->user->email_verified_at == null) {
            $token->user->email_verified_at = Carbon::now();
            $token->user->save();
        }

        activity('auth')
            ->event('verifyLogin')
            ->performedOn($token->user)
            ->withProperties([
                'ip' => $request->ip(),
                'method' => 'Magic Link'
            ])
            ->log('Successful authentication');

        return redirect('/');
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        activity('auth')
            ->event('logout')
            ->performedOn($request->user())
            ->withProperties([
                'ip' => $request->ip(),
            ])
            ->log('Logged out');

        Auth::logout();
        return redirect(route('login'));
    }
}
