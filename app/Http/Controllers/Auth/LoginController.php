<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(Request $request): View
    {
        $redirect = $request->string('redirect')->toString();

        if ($redirect !== '' && str_starts_with($redirect, url('/'))) {
            $request->session()->put('url.intended', $redirect);
        }

        return view('login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $this->mergeSessionCartIntoDb($request, Auth::user());

        if (Auth::user()->admin) {
            return redirect()->route('admin.index');
        }

        return redirect()->intended('/homepage.html');
    }

    private function mergeSessionCartIntoDb(Request $request, User $user): void
    {
        $sessionCart = (array) $request->session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        $dbCart = Cart::getForUser($user);

        foreach ($sessionCart as $bookId => $quantity) {
            $id           = (int) $bookId;
            $dbCart[$id]  = min(99, ($dbCart[$id] ?? 0) + (int) $quantity);
        }

        Cart::saveForUser($user, $dbCart);
        $request->session()->forget('cart');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login.html');
    }
}
